<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'booking_id' => Str::uuid(), // override di seeder
            'user_id' => 1, // override di seeder
            'payment_method' => $this->faker->randomElement(['transfer', 'credit_card', 'cash']),
            'paid_at' => $this->faker->dateTimeThisMonth()->format('Y-m-d'),
            'amount' => $this->faker->randomFloat(2, 500, 5000),
            'payment_proof' => null,
            'status' => $this->faker->randomElement(['pending', 'waiting', 'approved', 'confirmed', 'canceled']),
            'code_payment' => strtoupper(Str::random(8)),
        ];
    }
}
