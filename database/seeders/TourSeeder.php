<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();
        $category = Category::inRandomOrder()->first();

        $tours = [
            [
                'title' => 'Explore Gili Trawangan 3 Hari',
                'description' => 'Nikmati keindahan pantai dan budaya Gili Trawangan selama 3 hari 2 malam.',
                'price' => 1500000,
                'duration' => 3,
            ],
            [
                'title' => 'Tour Gili Meno',
                'description' => 'Petualangan menyaksikan matahari terbit dari Gili Meno.',
                'price' => 850000,
                'duration' => 2,
            ],
            [
                'title' => 'Wisata Gili Air',
                'description' => 'Jelajahi bawang laut, snorkling, dan kuliner khas ikan.',
                'price' => 1200000,
                'duration' => 3,
            ],
        ];

        foreach ($tours as $data) {
            Tour::create([
                'id' => Str::uuid(),
                'title' => $data['title'],
                'slug' => Str::slug($data['title']) . '-' . Str::random(5),
                'description' => $data['description'],
                'price' => $data['price'],
                'duration' => $data['duration'],
                'user_id' => $admin->id,
                'category_id' => $category->id,
            ]);
        }
    }
}
