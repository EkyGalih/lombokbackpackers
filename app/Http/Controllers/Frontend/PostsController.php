<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show($slug)
    {
        $post = Posts::where('slug', $slug)->first();

        return view('frontend.posts.show', compact('post'));
    }
}
