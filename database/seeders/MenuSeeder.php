<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::truncate();

        // Menu utama
        $beranda = Menu::create([
            'title' => 'Beranda',
            'url' => '/',
            'sort_order' => 1,
            'parent_id' => null,
            'active' => true,
        ]);

        $tentang = Menu::create([
            'title' => 'Tentang',
            'url' => '/tentang',
            'sort_order' => 2,
            'parent_id' => null,
            'active' => true,
        ]);

        $layanan = Menu::create([
            'title' => 'Layanan',
            'url' => '/layanan',
            'sort_order' => 3,
            'parent_id' => null,
            'active' => true,
        ]);

        // Submenu Layanan
        Menu::create([
            'title' => 'Paket Wisata',
            'url' => '/layanan/paket-wisata',
            'sort_order' => 1,
            'parent_id' => $layanan->id,
            'active' => true,
        ]);

        Menu::create([
            'title' => 'Sewa Mobil',
            'url' => '/layanan/sewa-mobil',
            'sort_order' => 2,
            'parent_id' => $layanan->id,
            'active' => true,
        ]);
    }
}
