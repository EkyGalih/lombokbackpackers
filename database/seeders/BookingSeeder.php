<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::value('id');
        $tourId = Tour::value('id');

        if (!$userId || !$tourId) {
            $this->command->error('Seed users & tours dulu bro.');
            return;
        }

        Booking::factory()
            ->count(5)
            ->create([
                'user_id' => $userId,
                'tour_id' => $tourId,
            ]);
    }
}
