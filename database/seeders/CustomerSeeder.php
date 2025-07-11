<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => fake()->name,
                'email' => fake()->unique()->safeEmail,
                'password' => bcrypt('password'),
                'role' => 'user',
                'is_active' => true,
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
