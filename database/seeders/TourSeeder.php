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
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->firstOrFail();
        $category = Category::inRandomOrder()->firstOrFail();

        $users = User::where('id', '!=', $admin->id)->get(); // semua user kecuali admin

        $tours = [
            [
                'title' => 'Explore Gili Trawangan 3 Hari',
                'description' => 'Nikmati keindahan pantai dan budaya Gili Trawangan selama 3 hari 2 malam.',
                'notes' => 'Bawa perlengkapan snorkeling pribadi jika ada.',
                'include' => 'Transport, makan, tiket masuk',
                'exclude' => 'Pengeluaran pribadi, tip guide',
                'itinerary' => 'Hari 1: Kedatangan & check-in. Hari 2: Snorkeling & tur. Hari 3: Free & pulang.',
                'packet' => '1-2 orang Rp. 1.500.000, 3-5 orang Rp. 3.000.000',
                'duration' => 3,
                'discount' => 100_000,
                'discount_start' => Carbon::now()->startOfMonth(),
                'discount_end' => Carbon::now()->endOfMonth(),
                'status' => 'available',
                'rating' => 4.5,
                'reviews_count' => 12,
                'status' => 'available',
            ],
            [
                'title' => 'Tour Gili Meno',
                'description' => 'Petualangan menyaksikan matahari terbit dari Gili Meno.',
                'notes' => 'Cocok untuk pasangan honeymoon.',
                'include' => 'Transport, tiket kapal, guide',
                'exclude' => 'Makan malam',
                'itinerary' => 'Hari 1: Sunset cruise. Hari 2: Pulang.',
                'packet' => '1-2 orang Rp. 850.000, 3-5 orang Rp. 1.500.000',
                'duration' => 2,
                'discount' => null,
                'discount_start' => null,
                'discount_end' => null,
                'status' => 'available',
                'rating' => 4.0,
                'reviews_count' => 8,
                'status' => 'available',
            ],
            [
                'title' => 'Wisata Gili Air',
                'description' => 'Jelajahi bawah laut, snorkeling, dan kuliner khas ikan.',
                'notes' => 'Perlu booking minimal 3 hari sebelumnya.',
                'include' => 'Transport, tiket snorkeling',
                'exclude' => 'Makan siang',
                'itinerary' => 'Hari 1: Check-in & snorkeling. Hari 2: City tour.',
                'packet' => '1-2 orang Rp. 1.200.000, 3-5 orang Rp. 2.000.000',
                'duration' => 3,
                'discount' => 50_000,
                'discount_start' => Carbon::now()->addDays(5),
                'discount_end' => Carbon::now()->addDays(15),
                'status' => 'not available',
                'rating' => 0,
                'reviews_count' => 0,
                'status' => 'not available',
            ],
        ];

        foreach ($tours as $data) {
            $tour = Tour::create([
                'id' => Str::uuid(),
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']) . '-' . Str::random(5),
                'description' => $data['description'],
                'notes' => $data['notes'],
                'include' => $data['include'],
                'exclude' => $data['exclude'],
                'itinerary' => $data['itinerary'],
                'packet' => $data['packet'],
                'duration' => $data['duration'],
                'discount' => $data['discount'],
                'discount_start' => $data['discount_start'],
                'discount_end' => $data['discount_end'],
                'status' => $data['status'],
                'rating' => $data['rating'],
                'reviews_count' => $data['reviews_count'],
                'status' => $data['status'],
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
