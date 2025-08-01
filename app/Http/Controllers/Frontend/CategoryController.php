<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tour;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name', 'slug')
            ->with(['tours'])
            ->withCount('tours')
            ->get();
        return view('frontend.categories.index', compact('categories'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->select('id', 'name', 'overview', 'description')
            ->first();
        $tours_by_category = Tour::where('category_id', $category->id)
            ->with(['media', 'ratings'])
            ->orderBy('order')
            ->get();
        return view('frontend.categories.show', compact('category', 'tours_by_category'));
    }
}
