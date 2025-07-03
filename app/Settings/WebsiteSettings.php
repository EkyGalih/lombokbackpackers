<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class WebsiteSettings extends Settings
{
    public string $site_name;
    public ?string $site_logo;
    public ?string $favicon;
    public ?string $header_image;
    public ?string $contact_email;
    public ?string $contact_phone;
    public ?string $contact_address;

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
            'site_name'        => 'Travelnesia',
            'site_logo'        => null,
            'favicon'          => null,
            'header_image'     => null,
            'contact_email'    => 'info@example.com',
            'contact_phone'    => '+62 812-3456-7890',
            'contact_address'  => 'Jl. Merdeka No. 123, Jakarta',
        ];
    }
}
