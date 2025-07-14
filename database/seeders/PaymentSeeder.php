<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::value('id');

        $bookings = Booking::all();

        if (!$userId || $bookings->isEmpty()) {
            $this->command->error('Seed bookings dulu bro.');
            return;
        }

        foreach ($bookings as $booking) {
            Payment::factory()->create([
                'booking_id' => $booking->id,
                'user_id' => $userId,
                'amount' => $booking->total_price,
                'status' => 'paid',
            ]);
        }
    }
}
