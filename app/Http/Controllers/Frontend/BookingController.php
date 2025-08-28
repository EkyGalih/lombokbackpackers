<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmedPaymentMail;
use App\Models\Booking;
use App\Models\BookingClick;
use App\Models\Tour;
use App\Settings\WebsiteSettings;
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

    public function booking($id)
    {
        // Ambil data paket tour
        $tour = Tour::findOrFail($id);

        // Nomor WhatsApp Admin/CS
        $nomorCS = app(WebsiteSettings::class)->contact_phone; // Ganti dengan nomor CS kamu (tanpa + atau 0 di depan)

        // Buat pesan
        $pesan = urlencode(
            __('message.message') . "\n"
                . "{$tour->title}\n"
            // . "Harga: Rp " . number_format($tour->price) . "\n"
        );

        // Buat URL WhatsApp
        $waUrl = "https://wa.me/{$nomorCS}?text={$pesan}";

        // Redirect ke WhatsApp
        return redirect()->away($waUrl);
    }

    public function book(Request $request)
    {
        $tour_packet = Tour::where('id', $request->program)->value('title');
        // Nomor WhatsApp Admin/CS
        $nomorCS = app(WebsiteSettings::class)->contact_phone; // Ganti dengan nomor CS kamu (tanpa + atau 0 di depan)

        // Ambil IP & lokasi
        $ip = $request->ip();
        $location = geoip($ip);

        // Buat data tracking baru setiap kali klik
        $click = new BookingClick();
        $click->ip_address      = $ip;
        $click->country         = $location->country ?? null;
        $click->city            = $location->city ?? null;
        $click->program         = $tour_packet ?? null;
        $click->referer         = $request->header('referer');
        $click->user_agent      = $request->header('User-Agent');
        $click->session_id      = session()->getId();
        $click->last_clicked_at = now();
        $click->click_count     = 1; // selalu mulai dari 1

        $click->save();

        // Buat pesan
        $pesan = urlencode(
            __('message.message') . "\n\n"
                . __('message.form.name') . ": {$request->nama}\n"
                . __('message.form.pax') . ": {$request->pax} " . __('message.form.people') . "\n"
                . __('message.form.national') . ": {$request->nationality}\n"
                . __('message.form.program') . ": {$tour_packet}\n"
                . __('message.form.dep_date') . ": {$request->dep_date}\n"
                . __('message.form.message') . ": {$request->pesan}\n\n"
                . __('message.form.thanks')
        );

        // Buat URL WhatsApp
        $waUrl = "https://wa.me/{$nomorCS}?text={$pesan}";

        // Redirect ke WhatsApp
        return redirect()->away($waUrl);
    }
}
