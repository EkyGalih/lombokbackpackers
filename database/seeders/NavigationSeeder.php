<?php

namespace Database\Seeders;

use App\Models\NavigationItems;
use App\Models\Navigations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nav = Navigations::create([
            'name' => 'Main Menu',
            'handle' => 'main-menu',
        ]);

        $home = NavigationItems::create([
            'navigations_id' => $nav->id,
            'title' => 'Home',
            'url' => '/',
        ]);

        $about = NavigationItems::create([
            'navigations_id' => $nav->id,
            'title' => 'About',
            'url' => '/about',
        ]);

        $services = NavigationItems::create([
            'navigations_id' => $nav->id,
            'title' => 'Services',
            'url' => '/services',
        ]);

        NavigationItems::create([
            'navigations_id' => $nav->id,
            'title' => 'Web Development',
            'url' => '/services/web',
            'parent_id' => $services->id,
        ]);

        NavigationItems::create([
            'navigations_id' => $nav->id,
            'title' => 'Mobile Apps',
            'url' => '/services/mobile',
            'parent_id' => $services->id,
        ]);
    }
}
