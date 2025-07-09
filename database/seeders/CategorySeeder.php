<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
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
            ],
        ];

        foreach ($categories as $data) {
            Category::create([
                'name' => $data['name'],           // array
                'description' => $data['description'], // array
            ]);
        }
    }
}
