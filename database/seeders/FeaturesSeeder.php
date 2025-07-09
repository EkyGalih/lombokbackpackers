<?php

namespace Database\Seeders;

use App\Models\Features;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class FeaturesSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [
                'title' => [
                    'en' => 'Fast Booking',
                    'id' => 'Pemesanan Cepat',
                ],
                'description' => [
                    'en' => 'Book your trip in just a few clicks.',
                    'id' => 'Pesan perjalanan Anda hanya dalam beberapa klik.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e',
            ],
            [
                'title' => [
                    'en' => 'Best Price Guarantee',
                    'id' => 'Jaminan Harga Terbaik',
                ],
                'description' => [
                    'en' => 'We offer you the best price for your adventure.',
                    'id' => 'Kami menawarkan harga terbaik untuk petualangan Anda.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470',
            ],
            [
                'title' => [
                    'en' => '24/7 Support',
                    'id' => 'Dukungan 24/7',
                ],
                'description' => [
                    'en' => 'Our team is ready to assist you anytime.',
                    'id' => 'Tim kami siap membantu Anda kapan saja.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0',
            ],
        ];

        $manager = new ImageManager(['driver' => 'gd']);

        foreach ($features as $feature) {
            $feat = Features::create([
                'id' => Str::uuid(),
                'title' => $feature['title'],
                'description' => $feature['description'],
            ]);

            // Download image
            $imageContents = Http::get($feature['image_url'])->body();
            $uuid = Str::uuid();
            $directory = 'media/features';
            $fileName = "$uuid.jpg";
            $path = "$directory/$fileName";

            Storage::disk('public')->put($path, $imageContents);

            $image = $manager->make(Storage::disk('public')->path($path));

            $media = Media::create([
                'disk' => 'public',
                'directory' => 'media',
                'visibility' => 'public',
                'name' => $fileName,
                'path' => $path,
                'width' => $image->width(),
                'height' => $image->height(),
                'size' => Storage::disk('public')->size($path),
                'type' => 'image',
                'ext' => 'jpg',
                'alt' => $feature['title']['en'],
                'title' => $feature['title']['en'],
                'description' => $feature['description']['en'],
                'caption' => $feature['title']['en'],
                'exif' => json_encode($image->exif() ?: []),
                'curations' => null,
            ]);

            $feat->media()->attach($media->id);
        }
    }
}
// This seeder creates features for the application, downloading images from specified URLs and storing them in the media library.
