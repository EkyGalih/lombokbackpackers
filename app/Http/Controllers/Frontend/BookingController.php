<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('tour', 'payment')->latest()->paginate(10);
        return view('frontend.bookings.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'booking_date' => 'required|date|after:today',
        ]);

        $tour = Tour::findOrFail($request->tour_id);

        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->tour_id = $request->tour_id;
        $booking->booking_date = $request->booking_date;
        $booking->total_price = $tour->price;
        $booking->save();

        return redirect()->route('payments.create', $booking->id)->with('success', 'Booking berhasil dibuat!');
    }

    public function show($id)
    {
        $booking = Booking::with(['tour', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('frontend.bookings.show', compact('booking'));
    }

    public function uploadProof(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $booking->update([
            'payment_proof' => $path,
            'payment_method' => 'manual',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Tunggu konfirmasi admin.');
    }
}
