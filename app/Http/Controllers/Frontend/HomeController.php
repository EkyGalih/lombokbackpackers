<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Features;
use App\Models\Posts;
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


        // Fetch the latest tours, categories, and features`
        $tours = Tour::latest()->take(6)->get();
        $categories = Category::with(['tours'])->get();
        $features = Features::all();
        $popularTours = Tour::orderByDesc('rating')->take(6)->get();
        $slides = Slides::limit(3)->orderByDesc('updated_at')->get();
        $features = Features::limit(4)->orderByDesc('updated_at')->get();
        $posts = Posts::limit(3)->orderByDesc('updated_at')->get();
        $customers = Customer::with('user')->whereHas(
            'user',
            fn($query) =>
            $query->whereNotNull('email_verified_at')
                ->where('is_active', true)
        )->get();

        // Return the landing view with the fetched data
        return view('landing', compact(
            'tours',
            'categories',
            'features',
            'popularTours',
            'headerImage',
            'headerTitle',
            'headerSubTitle',
            'slides',
            'features',
            'posts',
            'customers'
        ));
    }
}
