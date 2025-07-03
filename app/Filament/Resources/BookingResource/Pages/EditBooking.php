<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Enums\BookingStatus;
use App\Filament\Resources\BookingResource;
use App\Models\Payment;
use App\Notifications\BookingStatusChanged;
use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('Verifikasi Pembayaran')
                ->visible(fn($record) => $record->status === BookingStatus::Pending && $record->payment_proof)
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update([
                        'status' => BookingStatus::Approved,
                        'paid_at' => now(),
                    ]);

                    Payment::create([
                        'booking_id' => $record->id,
                        'user_id' => $record->user_id,
                        'amount' => $record->total_price,
                        'method' => 'manual',
                        'status' => 'confirmed',
                        'transaction_id' => 'manual-' . Str::uuid(),
                    ]);
                })
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $originalStatus = $this->record->status;

        // update record
        $this->record->fill($data);

        // cek apakah status berubah
        if ($originalStatus !== $data['status']) {
            $this->record->save();
            $this->record->user->notify(new BookingStatusChanged($this->record));
        }

        return $data;
    }
}
