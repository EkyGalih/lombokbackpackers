<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function show($slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();
        return view('frontend.tours.show', compact('tour'));
    }
}
