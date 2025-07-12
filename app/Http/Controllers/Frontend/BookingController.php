<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmedPaymentMail;
use App\Models\Booking;
use App\Models\Tour;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $bookings = $user->bookings()->with('tour.category')->latest()->paginate(10);

        $tours = \App\Models\Tour::with('category')->get();

        return view('frontend.bookings.index', compact('bookings', 'tours'));
    }

    public function store(Request $request)
    {
        // Ambil harga dari string packet
        // Misalnya "2 Person, 1.600.000"
        $packetParts = explode(',', $request->packet);
        $priceString = trim($packetParts[1] ?? '0');

        // Bersihkan dari titik & konversi ke float
        $priceDecimal = (float) str_replace('.', '', $priceString);

        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->tour_id = $request->tour_id;
        $booking->packet = $request->packet;
        $booking->arrival_date = $request->travel_date;
        $booking->total_price = $priceDecimal;
        $booking->notes = $request->notes;
        $booking->save();

        // kirim email ke user
        Mail::to($request->email)->send(new ConfirmedPaymentMail($booking));

        return redirect()->route('bookings.verify', $booking->id)->with('success', 'Booking berhasil dibuat!');
    }

    public function show(Booking $booking)
    {
        return view('frontend.bookings.show', compact('booking'));
    }

    public function verify(Booking $booking)
    {
        return view('emails.bookings.verify', compact('booking'));
    }

    public function download(Booking $booking)
    {
        // buat PDF
        $pdf = Pdf::loadView('frontend.bookings.invoice', [
            'booking' => $booking,
        ]);

        $filename = 'invoice-' . $booking->payment->code_payment . '.pdf';

        return $pdf->download($filename);
    }
}
