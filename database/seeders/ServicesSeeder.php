<?php

namespace Database\Seeders;

use App\Models\Services;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => [
                    'en' => 'Island Hopping',
                    'id' => 'Wisata Pulau',
                ],
                'description' => [
                    'en' => 'Explore beautiful islands and enjoy the crystal-clear waters and white sandy beaches.',
                    'id' => 'Jelajahi pulau-pulau indah dengan air laut jernih dan pasir putih yang menawan.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1582719478170-2fd53b4b2a4f?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => [
                    'en' => 'Mountain Trekking',
                    'id' => 'Pendakian Gunung',
                ],
                'description' => [
                    'en' => 'Experience breathtaking mountain views and adventurous trekking trails.',
                    'id' => 'Rasakan pemandangan gunung yang menakjubkan dengan jalur pendakian yang menantang.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => [
                    'en' => 'Cultural Tours',
                    'id' => 'Wisata Budaya',
                ],
                'description' => [
                    'en' => 'Discover the rich culture and traditions of local communities.',
                    'id' => 'Temukan budaya dan tradisi kaya masyarakat lokal.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1533499513792-8c4483b7247c?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($services as $data) {
            $service = Services::create([
                'id' => Str::uuid(),
                'title' => $data['title'],
                'description' => $data['description'],
            ]);

            $media = $this->downloadAndSaveMedia(
                $data['image_url'],
                'service-' . Str::uuid() . '.jpg',
                $data['title']['en']
            );

            if ($media) {
                $service->media()->attach($media->id);
            }
        }
    }

    /**
     * Download image, save to storage and create Media record.
     */
    protected function downloadAndSaveMedia(string $url, string $filename, string $title): ?Media
    {
        $response = Http::get($url);

        if (! $response->ok()) {
            return null;
        }

        $path = 'media/services/' . $filename;

        Storage::disk('public')->put($path, $response->body());

        return Media::create([
            'disk' => 'public',
            'directory' => 'media/services',
            'visibility' => 'public',
            'name' => pathinfo($filename, PATHINFO_FILENAME),
            'path' => $path,
            'width' => null,
            'height' => null,
            'size' => Storage::disk('public')->size($path),
            'type' => 'image',
            'ext' => pathinfo($filename, PATHINFO_EXTENSION),
            'alt' => $title,
            'title' => $title,
        ]);
    }
}
