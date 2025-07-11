<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ratings;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::all();
        return view('frontend.tours.index', compact('tours'));
    }

    public function show($slug)
    {
        $tour = Tour::with(['ratings.user', 'seoMeta'])->where('slug', $slug)->firstOrFail();

        // di controller
        $itinerary = [
            [
                'day' => 1,
                'date' => '2025-03-25',
                'title' => 'Cairo – Alexandria (1 Night)',
            ],
            [
                'day' => 2,
                'date' => '2025-03-26',
                'title' => 'Alexandria – Cairo (2 Nights)',
            ],
            [
                'day' => 3,
                'date' => '2025-03-27',
                'title' => 'Cairo – Abu Simbel – Aswan – Nile Cruise (3 Nights)',
            ],
            [
                'day' => 4,
                'date' => '2025-03-28',
                'title' => 'On Board – Aswan – Kom Ombo – Edfu – On Board',
            ],
            [
                'day' => 5,
                'date' => '2025-03-29',
                'title' => 'Hurghada – Cairo – Departure',
            ],
        ];

        $image_url = 'https://source.unsplash.com/800x600/?mountains,hiking';

        return view('frontend.tours.show', [
            'tour' => $tour,
            'seoMeta' => $tour->seoMeta,
            'itinerary' => $itinerary,
            'image_url' => $image_url
        ]);
    }

    public function rate(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|uuid|exists:tours,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Ratings::updateOrCreate(
            [
                'tour_id' => $request->tour_id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Terima kasih atas rating dan ulasannya!');
    }
}
