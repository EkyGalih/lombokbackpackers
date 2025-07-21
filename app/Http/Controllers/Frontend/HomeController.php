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
use Biostate\FilamentMenuBuilder\Models\Menu;

class HomeController extends Controller
{
    public function index()
    {
        // Website Settings
        $headerImage = app(WebsiteSettings::class)->header_image;
        $headerTitle = app(WebsiteSettings::class)->header_title;
        $headerSubTitle = app(WebsiteSettings::class)->header_sub_title;
        $MainMenu = Menu::first();
        $menu = $MainMenu?->items()
            ->whereNull('parent_id')
            ->with('children.children.children')
            ->defaultOrder()
            ->get() ?? collect();

        // Fetch the latest tours, categories, and features`
        $data = Tour::orderByDesc('updated_at')->get();
        $programs = $data->map(function ($tour) {
            return [
                'id' => $tour->id,
                'title' => $tour->title,
                'packet' => $tour->packet,
            ];
        });
        $tours = Tour::latest()->take(6)->get();
        $categories = Category::with(['tours'])->get();
        $features = Features::all();
        $popularTours = Tour::orderByDesc('rating')->take(6)->get();
        $slides = Category::orderByDesc('updated_at')->where('show_to_home', true)->get();
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
            'menu',
            'tours',
            'programs',
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

    public function dashboard()
    {
        $user = auth()->user();

        $recentBookings = $user->bookings()->latest()->take(5)->get();

        $chartLabels = [];
        $chartData = [];

        // Ambil data booking per bulan
        $bookingsPerMonth = $user->bookings()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = now()->startOfYear()->addMonths($i - 1)->format('M');
            $chartData[] = $bookingsPerMonth[$i] ?? 0;
        }

        return view('dashboard', compact('recentBookings', 'chartLabels', 'chartData'));
    }
}
