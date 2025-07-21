<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function show($slug)
    {
        $page = Pages::where('slug', $slug)->first();

        return view('frontend.pages.show', compact('page'));
    }
}
