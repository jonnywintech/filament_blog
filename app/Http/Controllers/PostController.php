<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);

        return view('pages.home.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id)->first();

        return view('pages.home.show', compact('post'));
    }
}
