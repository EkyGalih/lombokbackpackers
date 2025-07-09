<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Features;
use App\Models\Slides;
use App\Models\Tour;
use App\Settings\WebsiteSettings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Website Settings
        $headerImage = app(WebsiteSettings::class)->header_image;
        $headerTitle = app(WebsiteSettings::class)->header_title;
        $headerSubTitle = app(WebsiteSettings::class)->header_sub_title;


        // Fetch the latest tours, categories, and features
        $tours = Tour::latest()->take(6)->get();
        $categories = Category::all();
        $features = Features::all();
        $popularTours = Tour::orderByDesc('rating')->take(6)->get();
        $slides = Slides::limit(3)->get();

        // Return the landing view with the fetched data
        return view('landing', compact('tours', 'categories', 'features', 'popularTours', 'headerImage', 'headerTitle', 'headerSubTitle', 'slides'));
    }
}
