<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home', ['categories' => categories::all()]);
    }

    public function create()
    {
        return view('create', ['id' => Auth::id(), 'categories' => categories::all()]);
    }

    public function store(Request $request)
    {
        // define validator rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // check if validator error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // create categories
        $category = categories::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return redirect('/home');
    }

    public function edit($id)
    {
        return view('edit', [
            'categories' => categories::find($id),
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = categories::find($id);

        // validator rules disini
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // check if validator error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // check if name exist
        if ($request->has('name')) {
            // upload new name
            $name = $request->name;

            // delete old name
            $category->name->delete();

            // update category with new name
            $category->update([
                'name' => $request->name
            ]);
        }

        return redirect('/home');
    }

    public function delete($id)
    {
        $category = categories::find($id);

        // delete article
        $category->delete();

        // return response of delete
        return redirect('/home');
    }
}
