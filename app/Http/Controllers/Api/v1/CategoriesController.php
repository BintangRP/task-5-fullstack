<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index()
    {
        // get categories
        $posts = categories::latest()->paginate(5);

        // return collection categories as resource
        return new CategoriesResource(true, 'List data categories', $posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // check if validator fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = categories::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        // return response of categoriesResource
        return new CategoriesResource(true, 'Data categories berhasil ditambahkan', $post);
    }

    public function show(categories $categories)
    {
        // return single post as a resource
        return new CategoriesResource(true, 'Data post ditemukan', $categories);
    }
}
