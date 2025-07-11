<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class WebsiteSettings extends Settings
{
    public string $site_name;
    public ?string $site_logo;
    public ?string $favicon;
    public ?string $header_image;
    public ?string $header_title;
    public ?string $header_sub_title;
    public ?string $contact_email;
    public ?string $contact_phone;
    public ?string $contact_address;
    public ?string $social_facebook;
    public ?string $social_instagram;
    public ?string $social_x;
    public ?string $social_youtube;

    public static function group(): string
    {
        return 'website-settings';
    }

    /**
     * Provide default values for the settings.
     */
    public static function defaults(): array
    {
        return [
            'site_name'        => ENV('APP_NAME'),
            'site_logo'        => null,
            'favicon'          => null,
            'header_image'     => null,
            'header_title'     => 'Jelajahi Dunia Bersama ' . ENV('APP_NAME'),
            'header_sub_title' => 'Temukan paket tour terbaik, booking online, dan nikmati petualangan tak terlupakan.',
            'contact_email'    => 'info@example.com',
            'contact_phone'    => '+62 812-3456-7890',
            'contact_address'  => 'Jl. Merdeka No. 123, Jakarta',
            'social_facebook'   => 'lombokbackpackers',
            'social_instagram'  => 'lombokbackpackers',
            'social_x'          => 'lombokbackpackers',
            'social_youtube'    => 'lombokbackpackers',
        ];
    }
}
