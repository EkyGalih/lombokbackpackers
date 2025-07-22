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
    public ?string $maps;
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
            'maps'             => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.062782671887!2d116.09731897589434!3d-8.395486184703518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcddd8e22fb237b%3A0xa59f6613691f0165!2sLombok%20Backpackers%20tour%20%26%20travel!5e0!3m2!1sid!2sid!4v1753149572806!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'social_facebook'   => 'lombokbackpackers',
            'social_instagram'  => 'lombokbackpackers',
            'social_x'          => 'lombokbackpackers',
            'social_youtube'    => 'lombokbackpackers',
        ];
    }
}
