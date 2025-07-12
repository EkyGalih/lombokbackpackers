<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Mail\PaymentVerificationMail;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        return view('payments.create', compact('booking'));
    }

    public function payment(Request $request, Booking $booking)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $path = $request->file('proof_image')->store('media/payments', 'public');

        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->user_id = Auth::user()->id;
        $payment->payment_proof = $path;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $request->amount;
        $payment->status = 'verifying';
        $payment->paid_at = now();
        $payment->save();

        Mail::to(Auth::user()->email)->send(new PaymentVerificationMail($payment));

        return redirect()->route('payments.verify', $payment->id);
    }

    public function verify(Payment $payment)
    {
        return view('emails.payments.verify', compact('payment'));
    }
}
