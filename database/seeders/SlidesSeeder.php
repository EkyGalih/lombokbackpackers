<?php

namespace Database\Seeders;

use App\Models\Slides;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class SlidesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => [
                    'en' => 'Explore the World',
                    'id' => 'Jelajahi Dunia',
                ],
                'description' => [
                    'en' => 'Discover amazing places with us.',
                    'id' => 'Temukan tempat-tempat menakjubkan bersama kami.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e',
                'type' => 'tour',
            ],
            [
                'title' => [
                    'en' => 'Best Services',
                    'id' => 'Layanan Terbaik',
                ],
                'description' => [
                    'en' => 'We provide high quality services.',
                    'id' => 'Kami menyediakan layanan berkualitas tinggi.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470',
                'type' => 'services',
            ],
            [
                'title' => [
                    'en' => 'Your Adventure Starts Here',
                    'id' => 'Petualanganmu Dimulai di Sini',
                ],
                'description' => [
                    'en' => 'Plan your next trip with confidence.',
                    'id' => 'Rencanakan perjalanan berikutnya dengan percaya diri.',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0',
                'type' => 'features',
            ],
        ];

        $manager = new ImageManager(['driver' => 'gd']);

        foreach ($slides as $data) {
            $slide = Slides::create([
                'id' => Str::uuid(),
                'title' => $data['title'],
                'description' => $data['description'],
                'type' => $data['type'],
            ]);

            // Download image
            $imageContents = Http::get($data['image_url'])->body();
            $uuid = Str::uuid();
            $directory = 'media/slides';
            $fileName = "$uuid.jpg";
            $path = "$directory/$fileName";

            Storage::disk('public')->put($path, $imageContents);

            $image = $manager->make(Storage::disk('public')->path($path));

            // Save to media
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
                'alt' => $data['title']['en'],
                'title' => $data['title']['en'],
                'description' => $data['description']['en'],
                'caption' => $data['title']['en'],
                'exif' => json_encode($image->exif() ?: []),
                'curations' => null,
            ]);

            // Attach to slide
            $slide->media()->attach($media->id);
        }
    }
}
