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
                    'en' => '<p>Famous mountain in Lombok</p>',
                    'id' => '<p>Gunung terkenal di Lombok</p>',
                ],
                'image_url' => 'https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2024/01/18/fe5d29db-c715-488a-9797-cfbb32902a6b-1705549059543-e6c749536100cf7f8758860b09cbef03.png',
            ],
            [
                'name' => [
                    'en' => 'Sembalun',
                    'id' => 'Sembalun',
                ],
                'description' => [
                    'en' => '<p>Village at the foot of Mount Rinjani</p>',
                    'id' => '<p>Desa di kaki Gunung Rinjani</p>',
                ],
                'image_url' => 'https://www.pelago.com/img/products/ID-Indonesia/full-day-tour-lombok-north-beaches-mountain-waterfalls-and-sembalun/a36c2c26-362c-470e-a72b-19180e121ec6_full-day-tour-lombok-north-beaches-mountain-waterfalls-and-sembalun.jpg',
            ],
            [
                'name' => [
                    'en' => 'Mandalika',
                    'id' => 'Mandalika',
                ],
                'description' => [
                    'en' => '<p>Tourism area in Lombok</p>',
                    'id' => '<p>Kawasan wisata di Lombok</p>',
                ],
                'image_url' => 'https://asset.kompas.com/crops/GBFIdk6e1b5nwDgtIw0aKjc3R8A=/0x29:1200x829/1200x800/data/photo/2021/09/17/61444b6c6c9e3.png',
            ],
            [
                'name' => [
                    'en' => 'Gili Trawangan',
                    'id' => 'Gili Trawangan',
                ],
                'description' => [
                    'en' => '<p>Popular island near Lombok</p>',
                    'id' => '<p>Pulau populer di dekat Lombok</p>',
                ],
                'image_url' => 'https://assets.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/2023/05/08/Picsart_23-05-08_14-01-45-655-3116945051.jpg',
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
