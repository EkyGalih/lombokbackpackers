<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ratings;
use App\Models\Tour;
use App\Traits\HasPreview;
use Illuminate\Http\Request;

class TourController extends Controller
{
    use HasPreview;

    public function index()
    {
        $tours = Tour::all();
        return view('frontend.tours.index', compact('tours'));
    }

    public function show($slug)
    {
        $tour = Tour::with(['ratings.user', 'seoMeta'])->where('slug', $slug)->firstOrFail();

        $this->handlePreview($tour);

        return view('frontend.tours.show', [
            'tour' => $tour,
            'seoMeta' => $tour->seoMeta,
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
