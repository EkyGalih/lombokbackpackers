<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        for ($i = 0; $i < 10; $i++) {
            $uuid = Str::uuid();

            $user = User::create([
                'id' => $uuid,
                'name' => fake()->name,
                'email' => fake()->unique()->safeEmail,
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            Customer::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => fake()->phoneNumber,
                'address' => fake()->address,
                'nationality' => fake()->country,
                'gender' => fake()->randomElement(['male', 'female']),
                'date_of_birth' => fake()->date(),
            ]);
        }
    }
}
