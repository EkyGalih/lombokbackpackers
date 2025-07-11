<?php

namespace Database\Seeders;

use App\Models\Posts;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WebsiteSettingsSeeder::class,
            CategorySeeder::class,
            // TourSeeder::class,
            NavigationSeeder::class,
            FeaturesSeeder::class,
            ServicesSeeder::class,
            SlidesSeeder::class,
            PostsSeeder::class,
        ]);
    }
}
