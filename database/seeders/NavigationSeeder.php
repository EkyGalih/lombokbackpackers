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
            'name' => [
                'en' => 'Home',
                'id' => 'Beranda',
            ],
            'handle' => 'home',
            'order' => 1,
            'url' => '/',
        ]);

        $about = Navigations::create([
            'name' => [
                'en' => 'About Us',
                'id' => 'Tentang Kami',
            ],
            'handle' => 'about-us',
            'order' => 3,
            'url' => '/about',
        ]);

        $services = Navigations::create([
            'name' => [
                'en' => 'Services',
                'id' => 'Layanan',
            ],
            'handle' => 'services',
            'order' => 2,
            'url' => '/services',
        ]);

        $webDev = Navigations::create([
            'name' => [
                'en' => 'Web Development',
                'id' => 'Pengembangan Web',
            ],
            'handle' => 'web-development',
            'order' => 4,
            'url' => '/services/web',
            'parent_id' => $services->id,
        ]);

        $mobileApps = Navigations::create([
            'name' => [
                'en' => 'Mobile Apps',
                'id' => 'Aplikasi Mobile',
            ],
            'handle' => 'mobile-apps',
            'order' => 5,
            'url' => '/services/mobile',
            'parent_id' => $services->id,
        ]);
    }
}
