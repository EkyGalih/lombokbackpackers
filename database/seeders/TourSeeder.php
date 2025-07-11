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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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
                    'en' => '<p>Enjoy the beach and culture of Gili Trawangan for 3 days 2 nights.</p>',
                    'id' => '<p>Nikmati keindahan pantai dan budaya Gili Trawangan selama 3 hari 2 malam.</p>',
                ],
                'notes' => [
                    'en' => '<p>Bring your own snorkeling equipment if available.</p>',
                    'id' => '<p>Bawa perlengkapan snorkeling pribadi jika ada.</p>',
                ],
                'include' => [
                    'en' => '<p>Transport, meals, entrance tickets</p>',
                    'id' => '<p>Transport, makan, tiket masuk</p>',
                ],
                'exclude' => [
                    'en' => '<p>Personal expenses, guide tips</p>',
                    'id' => '<p>Pengeluaran pribadi, tip guide</p>',
                ],
                'itinerary' => [
                    'en' => 'Day 1: Arrival & check-in. Day 2: Snorkeling & tour. Day 3: Free & departure.',
                    'id' => 'Hari 1: Kedatangan & check-in. Hari 2: Snorkeling & tur. Hari 3: Free & pulang.',
                ],
                'packet' => [
                    'en' => [
                        ['value' => '1 Person, 900.000'],
                        ['value' => '2 Person, 1.500.000'],
                    ],
                    'id' => [
                        ['value' => '1 orang, 900.000'],
                        ['value' => '2 orang, 1.500.000'],
                    ],
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
                'image_url' => 'https://images.unsplash.com/photo-1578898886200-1bbf0d0061c1?auto=format&fit=crop&w=800&q=80',
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
                    'en' => [
                        ['value' => '1 Person, 850.000'],
                        ['value' => '2 Person, 1.500.000'],
                    ],
                    'id' => [
                        ['value' => '1 orang, 850.000'],
                        ['value' => '2 orang, 1.500.000'],
                    ],
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
                'image_url' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=800&q=80',
            ]
        ];

        $categories = Category::all();

        foreach ($categories as $category) {
            foreach ($tourTemplates as $template) {
                $imageResponse = Http::get($template['image_url']);
                $imageName = Str::uuid() . '.jpg';
                $storagePath = 'media/tours/' . $imageName;
                Storage::disk('public')->put($storagePath, $imageResponse->body());

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
                    'name' => pathinfo($imageName, PATHINFO_FILENAME),
                    'path' => $storagePath,
                    'width' => null,
                    'height' => null,
                    'size' => Storage::disk('public')->size($storagePath),
                    'type' => 'image',
                    'ext' => 'jpg',
                    'alt' => $template['title']['en'],
                    'title' => $template['title']['en'],
                ]);

                $tour->media()->attach($media->id);

                $tour->seoMeta()->create([
                    'meta_title' => 'Tour Package: ' . $template['title']['en'],
                    'meta_description' => Str::limit(strip_tags($template['description']['en']), 160),
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
