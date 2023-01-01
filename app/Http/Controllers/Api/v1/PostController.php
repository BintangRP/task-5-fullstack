<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Articles;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // get posts
        $posts = Articles::latest()->paginate(5);

        // return collection posts as a resource
        return new PostResource(true, 'List data posts', $posts);
    }
}
