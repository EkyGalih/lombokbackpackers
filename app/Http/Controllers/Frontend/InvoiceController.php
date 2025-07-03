<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function download(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() || $booking->status !== 'approved') {
            abort(403, 'Unauthorized');
        }

        $pdf = Pdf::loadView('invoices.booking', compact('booking'));

        return $pdf->download('invoice-booking-' . $booking->id . '.pdf');
    }
}
