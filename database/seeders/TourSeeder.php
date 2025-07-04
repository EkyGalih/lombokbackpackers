<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tour;
use App\Models\User;
use App\Models\Ratings;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();
        $category = Category::inRandomOrder()->first();

        $users = User::where('id', '!=', $admin->id)->get(); // semua user kecuali admin

        $tours = [
            [
                'title' => 'Explore Gili Trawangan 3 Hari',
                'description' => 'Nikmati keindahan pantai dan budaya Gili Trawangan selama 3 hari 2 malam.',
                'price' => 1_500_000,
                'package_person_count' => 1,
                'duration' => 3,
                'discount' => 100_000,
                'discount_start' => Carbon::now()->startOfMonth(),
                'discount_end' => Carbon::now()->endOfMonth(),
                'is_published' => true,
                'thumbnail' => 'tours/default1.jpg',
                'rating' => 4.5,
                'reviews_count' => 12,
            ],
            [
                'title' => 'Tour Gili Meno',
                'description' => 'Petualangan menyaksikan matahari terbit dari Gili Meno.',
                'price' => 850_000,
                'package_person_count' => 1,
                'duration' => 2,
                'discount' => null,
                'discount_start' => null,
                'discount_end' => null,
                'is_published' => true,
                'thumbnail' => 'tours/default2.jpg',
                'rating' => 4.0,
                'reviews_count' => 8,
            ],
            [
                'title' => 'Wisata Gili Air',
                'description' => 'Jelajahi bawah laut, snorkeling, dan kuliner khas ikan.',
                'price' => 1_200_000,
                'package_person_count' => 1,
                'duration' => 3,
                'discount' => 50_000,
                'discount_start' => Carbon::now()->addDays(5),
                'discount_end' => Carbon::now()->addDays(15),
                'is_published' => false,
                'thumbnail' => 'tours/default3.jpg',
                'rating' => 0,
                'reviews_count' => 0,
            ],
        ];

        foreach ($tours as $data) {
            $tour = Tour::create([
                'id' => Str::uuid(),
                'title' => $data['title'],
                'slug' => Str::slug($data['title']) . '-' . Str::random(5),
                'description' => $data['description'],
                'price' => $data['price'],
                'duration' => $data['duration'],
                'package_person_count' => $data['package_person_count'],
                'discount' => $data['discount'],
                'discount_start' => $data['discount_start'],
                'discount_end' => $data['discount_end'],
                'is_published' => $data['is_published'],
                'thumbnail' => $data['thumbnail'],
                'rating' => $data['rating'],
                'reviews_count' => $data['reviews_count'],
                'user_id' => $admin->id,
                'category_id' => $category->id,
            ]);

            $tour->seoMeta()->create([
                'meta_title' => 'Paket Tour: ' . $tour->title,
                'meta_description' => Str::limit($tour->description, 160),
                'keywords' => 'gili, tour, lombok, ' . $tour->title,
                'canonical_url' => url('/tours/' . $tour->slug),
                'robots' => 'index, follow',
            ]);

            // Tambahkan ratings
            $ratingsCount = rand(2, 5);
            $sumRating = 0;

            $randomUsers = $users->random(min($ratingsCount, $users->count()));

            foreach ($randomUsers as $user) {
                $ratingValue = rand(3, 5); // 3–5 bintang
                $sumRating += $ratingValue;

                Ratings::create([
                    'tour_id' => $tour->id,
                    'user_id' => $user->id,
                    'rating' => $ratingValue,
                    'comment' => fake()->sentence(),
                ]);
            }

            if ($ratingsCount > 0) {
                $tour->rating = $sumRating / $ratingsCount;
                $tour->reviews_count = $ratingsCount;
                $tour->save();
            }
        }
    }
}
