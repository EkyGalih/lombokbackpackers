<?php

namespace Database\Seeders;

use App\Models\Category;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Mountain Rinjani',
                    'id' => 'Gunung Rinjani',
                ],
                'description' => [
                    'en' => 'Famous mountain in Lombok',
                    'id' => 'Gunung terkenal di Lombok',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1603092242901-40aa10e7dcf2?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => [
                    'en' => 'Sembalun',
                    'id' => 'Sembalun',
                ],
                'description' => [
                    'en' => 'Village at the foot of Mount Rinjani',
                    'id' => 'Desa di kaki Gunung Rinjani',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1602821505409-69d4d4df4e3c?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => [
                    'en' => 'Mandalika',
                    'id' => 'Mandalika',
                ],
                'description' => [
                    'en' => 'Tourism area in Lombok',
                    'id' => 'Kawasan wisata di Lombok',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1621295403201-66a5bc7e7980?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => [
                    'en' => 'Gili Trawangan',
                    'id' => 'Gili Trawangan',
                ],
                'description' => [
                    'en' => 'Popular island near Lombok',
                    'id' => 'Pulau populer di dekat Lombok',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1606152737045-92f1c3bd6bc4?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($categories as $data) {
            $category = Category::create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            // Download gambar
            $imageResponse = Http::get($data['image_url']);
            $imageName = Str::uuid() . '.jpg';
            $storagePath = 'media/categories/' . $imageName;

            Storage::disk('public')->put($storagePath, $imageResponse->body());

            // Simpan media
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
                'alt' => $data['name']['en'],
                'title' => $data['name']['en'],
            ]);

            // Attach media ke kategori
            $category->media()->attach($media->id);
        }
    }
}
