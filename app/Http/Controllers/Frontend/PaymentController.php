<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        return view('payments.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'required|string|in:transfer,qris',
            'proof_image' => 'nullable|image|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('payment_proofs', 'public');
        }

        Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'status' => BookingStatus::Waiting, // Atau langsung 'confirmed' kalau tidak perlu verifikasi
            'proof_image' => $path,
            'transaction_id' => Str::uuid(),
            'payment_date' => now()
        ]);

        // Tandai booking sedang menunggu verifikasi pembayaran
        $booking->update([
            'status' => BookingStatus::Pending,
            'payment_method' => $validated['method'],
            'payment_proof' => $path,
            'paid_at' => now()
        ]);

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil dikirim. Tunggu konfirmasi admin.');
    }
}
