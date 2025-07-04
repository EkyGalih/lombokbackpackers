<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\LaravelSettings\Models\SettingsProperty;

class WebsiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'site_name'],
            ['payload' => json_encode(ENV('APP_NAME'))]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'site_logo'],
            ['payload' => json_encode(null)]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'favicon'],
            ['payload' => json_encode(null)]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'header_image'],
            ['payload' => json_encode(null)]
        );

        SettingsProperty::updateOrCreate(
            ['group' => 'website-settings', 'name' => 'header_title'],
            ['payload' => json_encode('Jelajahi Dunia Bersama ' . ENV('APP_NAME'))]
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
}
