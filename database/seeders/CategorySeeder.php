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
        $categories = ['Gili Trawangan', 'Gili Air', 'Gili Meno'];

        foreach ($categories as $name) {
            Category::create([
                'id' => Str::uuid(),
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
