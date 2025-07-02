<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('tour')->where('user_id', Auth::id())->latest()->get();
        return view('frontend.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['tour', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('frontend.bookings.show', compact('booking'));
    }
}
