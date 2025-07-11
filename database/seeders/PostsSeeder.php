<?php

namespace Database\Seeders;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class PostsSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = DB::table('users')->value('id'); // ambil user pertama

        $posts = [
            [
                'slug' => 'welcome-to-our-blog',
                'title' => [
                    'en' => 'Welcome to our Blog',
                    'id' => 'Selamat Datang di Blog Kami',
                ],
                'excerpt' => [
                    'en' => 'A short introduction to our blog.',
                    'id' => 'Pengantar singkat untuk blog kami.',
                ],
                'content' => [
                    'en' => 'This is the content of the blog post in English.',
                    'id' => 'Ini adalah isi postingan blog dalam Bahasa Indonesia.',
                ],
                'tags' => ['announcement', 'intro'],
                'status' => 'published',
                'unsplash_keyword' => 'blog',
            ],
            [
                'slug' => 'travel-tips',
                'title' => [
                    'en' => 'Travel Tips You Need to Know',
                    'id' => 'Tips Perjalanan yang Perlu Anda Ketahui',
                ],
                'excerpt' => [
                    'en' => 'Make your trip unforgettable.',
                    'id' => 'Buat perjalanan Anda tak terlupakan.',
                ],
                'content' => [
                    'en' => 'Tips for an amazing journey.',
                    'id' => 'Tips untuk perjalanan yang menyenangkan.',
                ],
                'tags' => ['travel', 'tips'],
                'status' => 'published',
                'unsplash_keyword' => 'travel',
            ],
            [
                'slug' => 'food-guide',
                'title' => [
                    'en' => 'A Guide to Local Food',
                    'id' => 'Panduan Kuliner Lokal',
                ],
                'excerpt' => [
                    'en' => 'Taste the best local cuisine.',
                    'id' => 'Nikmati kuliner lokal terbaik.',
                ],
                'content' => [
                    'en' => 'Explore the richness of local dishes.',
                    'id' => 'Jelajahi kekayaan kuliner daerah.',
                ],
                'tags' => ['food', 'guide'],
                'status' => 'draft',
                'unsplash_keyword' => 'food',
            ],
            [
                'slug' => 'mountain-adventure',
                'title' => [
                    'en' => 'Mountain Adventure Awaits',
                    'id' => 'Petualangan Gunung Menanti',
                ],
                'excerpt' => [
                    'en' => 'Experience the thrill of hiking.',
                    'id' => 'Rasakan sensasi mendaki.',
                ],
                'content' => [
                    'en' => 'Guide to a safe mountain trip.',
                    'id' => 'Panduan perjalanan gunung yang aman.',
                ],
                'tags' => ['adventure', 'mountain'],
                'status' => 'published',
                'unsplash_keyword' => 'mountain',
            ],
            [
                'slug' => 'city-breaks',
                'title' => [
                    'en' => 'Best City Break Destinations',
                    'id' => 'Destinasi Liburan Kota Terbaik',
                ],
                'excerpt' => [
                    'en' => 'Escape to vibrant cities.',
                    'id' => 'Kabur ke kota penuh warna.',
                ],
                'content' => [
                    'en' => 'Top cities to visit for a short trip.',
                    'id' => 'Kota-kota terbaik untuk perjalanan singkat.',
                ],
                'tags' => ['city', 'holiday'],
                'status' => 'draft',
                'unsplash_keyword' => 'city',
            ],
            [
                'slug' => 'cultural-experience',
                'title' => [
                    'en' => 'A Cultural Experience to Remember',
                    'id' => 'Pengalaman Budaya yang Tak Terlupakan',
                ],
                'excerpt' => [
                    'en' => 'Dive into local traditions.',
                    'id' => 'Menyelami tradisi lokal.',
                ],
                'content' => [
                    'en' => 'How to truly experience the culture.',
                    'id' => 'Cara merasakan budaya secara nyata.',
                ],
                'tags' => ['culture', 'experience'],
                'status' => 'published',
                'unsplash_keyword' => 'culture',
            ],
        ];

        foreach ($posts as $post) {
            $uuid = Str::uuid();

            // Download gambar dari Unsplash
            $response = Http::get("https://plus.unsplash.com/premium_photo-1720744786849-a7412d24ffbf?q=80&w=1109&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" . $post['unsplash_keyword']);
            $fileName = $uuid . '.jpg';
            $path = 'media/' . $fileName;

            Storage::disk('public')->put($path, $response->body());

            $image = Image::make(Storage::disk('public')->path($path));

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
                'alt' => $post['title']['en'],
                'title' => $post['title']['en'],
                'description' => $post['excerpt']['en'],
                'caption' => $post['title']['en'],
                'exif' => json_encode($image->exif() ?: []),
                'curations' => null,
            ]);

            DB::table('posts')->insert([
                'id' => $uuid,
                'title' => json_encode($post['title']),
                'slug' => $post['slug'],
                'excerpt' => json_encode($post['excerpt']),
                'content' => json_encode($post['content']),
                'tags' => json_encode($post['tags']),
                'status' => $post['status'],
                'author_id' => $authorId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
