<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tour;
use App\Models\User;
use App\Models\Ratings;
use Awcodes\Curator\Models\Media;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->firstOrFail();
        $users = User::where('id', '!=', $admin->id)->get();

        $tourTemplates = [
            [
                'title' => [
                    'en' => 'Explore Gili Trawangan 3 Days',
                    'id' => 'Jelajahi Gili Trawangan 3 Hari',
                ],
                'description' => [
                    'en' => 'Enjoy the beach and culture of Gili Trawangan for 3 days 2 nights.',
                    'id' => 'Nikmati keindahan pantai dan budaya Gili Trawangan selama 3 hari 2 malam.',
                ],
                'notes' => [
                    'en' => 'Bring your own snorkeling equipment if available.',
                    'id' => 'Bawa perlengkapan snorkeling pribadi jika ada.',
                ],
                'include' => [
                    'en' => 'Transport, meals, entrance tickets',
                    'id' => 'Transport, makan, tiket masuk',
                ],
                'exclude' => [
                    'en' => 'Personal expenses, guide tips',
                    'id' => 'Pengeluaran pribadi, tip guide',
                ],
                'itinerary' => [
                    'en' => 'Day 1: Arrival & check-in. Day 2: Snorkeling & tour. Day 3: Free & departure.',
                    'id' => 'Hari 1: Kedatangan & check-in. Hari 2: Snorkeling & tur. Hari 3: Free & pulang.',
                ],
                'packet' => [
                    'en' => '1-2 pax Rp. 1.500.000, 3-5 pax Rp. 3.000.000',
                    'id' => '1-2 orang Rp. 1.500.000, 3-5 orang Rp. 3.000.000',
                ],
                'duration' => [
                    'en' => '3 days',
                    'id' => '3 hari',
                ],
                'discount' => 100_000,
                'discount_start' => Carbon::now()->startOfMonth(),
                'discount_end' => Carbon::now()->endOfMonth(),
                'status' => 'available',
                'rating' => 4.5,
                'reviews_count' => 12,
                'image' => 'defaults/tours/default1.jpg',
            ],
            [
                'title' => [
                    'en' => 'Romantic Gili Meno Tour',
                    'id' => 'Tour Romantis Gili Meno',
                ],
                'description' => [
                    'en' => 'Witness the sunrise from Gili Meno — perfect for couples.',
                    'id' => 'Saksikan matahari terbit dari Gili Meno — cocok untuk pasangan.',
                ],
                'notes' => [
                    'en' => 'Ideal for honeymooners.',
                    'id' => 'Ideal untuk honeymoon.',
                ],
                'include' => [
                    'en' => 'Transport, boat ticket, guide',
                    'id' => 'Transport, tiket kapal, pemandu',
                ],
                'exclude' => [
                    'en' => 'Dinner',
                    'id' => 'Makan malam',
                ],
                'itinerary' => [
                    'en' => 'Day 1: Sunset cruise. Day 2: Departure.',
                    'id' => 'Hari 1: Sunset cruise. Hari 2: Pulang.',
                ],
                'packet' => [
                    'en' => '1-2 pax Rp. 850.000, 3-5 pax Rp. 1.500.000',
                    'id' => '1-2 orang Rp. 850.000, 3-5 orang Rp. 1.500.000',
                ],
                'duration' => [
                    'en' => '2 days',
                    'id' => '2 hari',
                ],
                'discount' => null,
                'discount_start' => null,
                'discount_end' => null,
                'status' => 'available',
                'rating' => 4.0,
                'reviews_count' => 8,
                'image' => 'defaults/tours/default2.jpg',
            ]
        ];

        $categories = Category::all();

        foreach ($categories as $index => $category) {
            // tiap kategori kita buat minimal 2 tour
            foreach ($tourTemplates as $template) {
                $tour = Tour::create([
                    'user_id' => $admin->id,
                    'category_id' => $category->id,
                    'title' => $template['title'],
                    'description' => $template['description'],
                    'notes' => $template['notes'],
                    'include' => $template['include'],
                    'exclude' => $template['exclude'],
                    'itinerary' => $template['itinerary'],
                    'packet' => $template['packet'],
                    'duration' => $template['duration'],
                    'discount' => $template['discount'],
                    'discount_start' => $template['discount_start'],
                    'discount_end' => $template['discount_end'],
                    'status' => $template['status'],
                    'rating' => $template['rating'],
                    'reviews_count' => $template['reviews_count'],
                ]);

                $media = Media::create([
                    'disk' => 'public',
                    'directory' => 'media',
                    'visibility' => 'public',
                    'name' => pathinfo($template['image'], PATHINFO_FILENAME),
                    'path' => $template['image'],
                    'width' => null,
                    'height' => null,
                    'size' => filesize(public_path($template['image'])),
                    'type' => 'image',
                    'ext' => pathinfo($template['image'], PATHINFO_EXTENSION),
                    'alt' => $template['title']['en'],
                    'title' => $template['title']['en'],
                ]);

                $tour->media()->attach($media->id);

                $tour->seoMeta()->create([
                    'meta_title' => 'Tour Package: ' . $template['title']['en'],
                    'meta_description' => Str::limit($template['description']['en'], 160),
                    'keywords' => 'gili, tour, lombok, ' . $template['title']['en'],
                    'canonical_url' => url('/tours/' . $tour->slug),
                    'robots' => 'index, follow',
                ]);

                $ratingsCount = rand(2, 5);
                $sumRating = 0;

                $randomUsers = $users->random(min($ratingsCount, $users->count()));

                foreach ($randomUsers as $user) {
                    $ratingValue = rand(3, 5);
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
}
