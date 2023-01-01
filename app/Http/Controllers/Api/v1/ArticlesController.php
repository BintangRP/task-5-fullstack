<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticlesResource;
use App\Models\Articles;
use App\Models\categories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // get articles
        $posts = Articles::latest()->paginate(5);

        // return collection of articles as a resource
        return new ArticlesResource(true, 'List data articles', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        // check validasi jika gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // upload image
        $image = $request->file('image');
        $imageName = $image;
        $image->storeAs('public/Articles', $imageName);

        // buat articles
        $articles = Articles::create([
            'image' => $imageName,
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'categories_id' => categories::whereBelongsTo(auth()->user())->pluck('id')->first(),
        ]);

        // return request response
        return new ArticlesResource(true, 'Data article berhasil ditambahkan', $articles);
    }

    public function show($id)
    {
        // return single article as resource
        return new ArticlesResource(true, 'Data article ditemukan', Articles::find($id));
    }

    public function update(Request $request, $id)
    {
        $articles = Articles::find($id);

        // define validator rules
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        // check if validator error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // check if image is not empty
        if ($request->hasFile('iamge')) {
            // upload image
            $image = $request->file('image');
            $image->storeAs('public/articles', $image);

            // delete old image
            Storage::delete('public/articles' . $articles->image);

            // update articles with new image
            $articles->update([
                'image' => $image,
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {
            // update articles without image
            $articles->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        // return response of update
        return new ArticlesResource(true, 'Data articles berhasil diubah', $articles);
    }


    // destroy
    public function destroy($id)
    {
        $article = Articles::find($id);
        // delete image
        Storage::delete('public/posts/' . $article->image);

        // delete article
        $article->delete();

        // return response delete
        return new ArticlesResource(true, 'Data article berhasil dihapus', null);
    }
}
