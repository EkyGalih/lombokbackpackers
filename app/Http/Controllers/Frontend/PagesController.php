<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use App\Traits\HasPreview;

class PagesController extends Controller
{
    use HasPreview;

    public function show($slug)
    {
        $page = Pages::where('slug', $slug)->first();

        $this->handlePreview($page);

        return view('frontend.pages.show', [
            'page' => $page,
            'meta' => $page->seoMeta
        ]);
    }
}
