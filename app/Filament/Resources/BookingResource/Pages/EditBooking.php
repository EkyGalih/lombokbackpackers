<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Enums\BookingStatus;
use App\Filament\Resources\BookingResource;
use App\Mail\PaymentApprovedMail;
use App\Models\Payment;
use App\Notifications\BookingStatusChanged;
use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // log record booking
        Log::info('EditBooking - Booking record updated', [
            'booking_id' => $this->record->id,
            'status' => $this->record->status->value,
            'tes_status' => BookingStatus::Approved->value
        ]);
        if ($this->record->status->value === BookingStatus::Approved->value) {
            $payment = $this->record->payment;
            // log payment
            Log::info('EditBooking - Payment record', [
                'payment_id' => $payment?->id,
                'payment_status' => $payment?->status,
            ]);
            if (! $payment) {
                Log::warning("EditBooking - Booking {$this->record->id} approved but no payment found.");
                return; // tidak ada payment => stop
            }

            // update status payment juga
            $payment->update([
                'status' => BookingStatus::Approved->value, // pastikan ini match
            ]);
            Log::info("EditBooking - Payment {$payment->id} status updated to approved.");
            Log::info('Sending email with payment', ['payment' => $payment]);

            // kirim email ke user dengan $payment, bukan $this->record
            Mail::to($this->record->user->email)->send(
                new PaymentApprovedMail($payment)
            );
            Log::info("EditBooking - Email sent to {$this->record->user->email}.");
        }
    }
}
