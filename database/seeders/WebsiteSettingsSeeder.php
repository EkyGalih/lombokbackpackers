<?php

namespace Database\Seeders;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\LaravelSettings\Models\SettingsProperty;

class WebsiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $appName = env('APP_NAME', 'MyApp');

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'site_name'],
            ['payload' => json_encode($appName)]
        );

        // Simpan logo
        $logoMedia = $this->downloadAndSaveMedia(
            'https://png.pngtree.com/png-clipart/20220617/ourmid/pngtree-cool-travelling-van-tropical-png-image_5125592.png',
            'site-logo-' . Str::random(8) . '.png',
            $appName . ' Logo'
        );

        // Simpan favicon
        $faviconMedia = $this->downloadAndSaveMedia(
            'https://png.pngtree.com/png-clipart/20220617/ourmid/pngtree-cool-travelling-van-tropical-png-image_5125592.png',
            'favicon-' . Str::random(8) . '.png',
            $appName . ' Favicon'
        );

        // Simpan header image
        $headerMedia = $this->downloadAndSaveMedia(
            'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjQLZPu6Aul1am6jriYgNGZhXfGhuUCl3PsSoXC2ibF7xQj5n0gBgxPWHJbojfxKWmAaFM7Msbrx1blMmOC0N99w_ZAoeUeDT4zyA9pVZGeSZSgxAWmxkWqrBY0ubJxf2Qrff4bdTVdgLc/s1600/Gili+Trawangan+3.jpg',
            'header-image-' . Str::random(8) . '.jpg',
            $appName . ' Header Image'
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'site_logo'],
            ['payload' => json_encode($logoMedia?->path)]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'favicon'],
            ['payload' => json_encode($faviconMedia?->path)]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'header_image'],
            ['payload' => json_encode($headerMedia?->path)]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'header_title'],
            ['payload' => json_encode('Jelajahi Dunia Bersama ' . $appName)]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'header_sub_title'],
            ['payload' => json_encode('Temukan paket tour terbaik, booking online, dan nikmati petualangan tak terlupakan.')]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'contact_email'],
            ['payload' => json_encode('admin@admin.com')]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'contact_phone'],
            ['payload' => json_encode('+6287700991538')]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'contact_address'],
            ['payload' => json_encode('Jl. Contoh Alamat No. 123')]
        );
    }

    /**
     * Download image, save to storage and create Media record.
     */
    protected function downloadAndSaveMedia(string $url, string $filename, string $title): ?Media
    {
        $response = Http::timeout(20)->get($url);

        if (! $response->ok()) {
            return null;
        }

        $path = 'media/settings/' . $filename;
        Storage::disk('public')->put($path, $response->body());

        return Media::create([
            'disk' => 'public',
            'directory' => 'media/settings',
            'visibility' => 'public',
            'name' => pathinfo($filename, PATHINFO_FILENAME),
            'path' => $path,
            'width' => null,
            'height' => null,
            'size' => Storage::disk('public')->size($path),
            'type' => 'image',
            'ext' => pathinfo($filename, PATHINFO_EXTENSION),
            'alt' => $title,
            'title' => $title,
        ]);
    }
}
