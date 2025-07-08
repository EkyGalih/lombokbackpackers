<?php

namespace Database\Seeders;

use App\Models\Navigations;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $home = Navigations::create([
            'name' => 'Home',
            'handle' => 'Home',
            'order' => 1,
            'url' => '/',
        ]);

        $about = Navigations::create([
            'name' => 'About',
            'handle' => 'About-Us',
            'order' => 3,
            'url' => '/about',
        ]);

        $services = Navigations::create([
            'name' => 'Services',
            'handle' => 'Services',
            'order' => 2,
            'url' => '/services',
        ]);

        Navigations::create([
            'name' => 'Web Development',
            'handle' => 'Web-Development',
            'order' => 4,
            'url' => '/services/web'
        ]);

        Navigations::create([
            'name' => 'Mobile Apps',
            'handle' => 'Mobile-Apps',
            'order' => 5,
            'url' => '/services/mobile'
        ]);
    }
}
