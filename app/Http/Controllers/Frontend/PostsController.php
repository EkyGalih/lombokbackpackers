<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Traits\HasPreview;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    use HasPreview;

    public function show($slug)
    {
        $post = Posts::where('slug', $slug)->first();

        $this->handlePreview($post);

        return view('frontend.posts.show', compact('post'));
    }
}
