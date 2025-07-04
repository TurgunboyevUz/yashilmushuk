<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Blog::where('status', 1)->get(['slug', 'title', 'image']);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Blog::where('slug', $slug)->where('status', 1)->firstOrFail();

        return view('blog.show', compact('post'));
    }
}
