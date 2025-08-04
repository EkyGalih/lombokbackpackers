<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Traits\HasPreview;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    use HasPreview;

    public function index(Request $request)
    {
        $query = Posts::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        // Filter by keyword
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->orderByDesc('updated_at')->paginate(8);
        $categories = Posts::pluck('category')->flatten()->unique();
        $allTags = Posts::pluck('tags')->flatten()->unique();

        $breadcrumb = 'Blog';

        if ($request->has('category')) {
            $breadcrumb .= ' > ' . $request->category;
        }

        if ($request->has('tag')) {
            $breadcrumb .= ' > ' . $request->tag;
        }

        if ($request->has('search')) {
            $breadcrumb .= " > '{$request->search}'";
        }

        if (!$request->all()) {
            $breadcrumb = $breadcrumb . " > " . __('message.post.title_all');
        }

        return view('frontend.posts.index', compact('posts', 'allTags', 'categories', 'breadcrumb'));
    }


    public function show($slug)
    {
        $post = Posts::where('slug', $slug)->first();

        // ambil tag dari post
        $tags = $post->tags;

        // query recent post yang memiliki setidaknya satu tag yang sama
        $recentPosts = Posts::where('id', '!=', $post->id)
            ->where(function ($query) use ($tags) {
                foreach ($tags as $tag) {
                    $query->orWhereJsonContains('tags', $tag);
                }
            })
            ->latest()
            ->take(4)
            ->get();

        // Jika hasil kosong, ambil random posts
        if ($recentPosts->isEmpty()) {
            $recentPosts = Posts::where('id', '!=', $post->id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        $this->handlePreview($post);

        return view('frontend.posts.show', [
            'post' => $post,
            'recentPosts' => $recentPosts,
            'meta' =>$post->seoMeta
        ]);
    }
}
