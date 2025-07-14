<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'user_id' => 1, // bisa di override di seeder
            'tour_id' => Str::uuid(), // bisa di override di seeder
            'packet' => $this->faker->randomElement(['1 Person, 500.000', '6 Person, 5.000.000', '3 Person, 1.500.000']),
            'code_booking' => strtoupper(Str::random(8)),
            'arrival_date' => $this->faker->dateTimeBetween('+1 days', '+30 days')->format('Y-m-d'),
            'total_price' => $this->faker->randomFloat(500000, 5000000, 1500000),
            'status' => $this->faker->randomElement(['pending', 'waiting', 'approved', 'confirmed', 'canceled']),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
