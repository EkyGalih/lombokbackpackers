<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme mode
    |--------------------------------------------------------------------------
    |
    | This option determines how the theme will be set for the application.
    | By default global mode is set to use one theme for all users. If you
    | want to set a theme for each user separately, then set to 'user'.
    |
    */

    'mode' => 'user',

    'default_theme' => 'dracula',

    'themes' => [
        'default' => [
            'name' => 'Default',
            'path' => 'vendor/themes/default.css',
        ],
        'nord' => [
            'name' => 'Nord',
            'path' => 'vendor/themes/nord.css',
        ],
        'dracula' => [
            'name' => 'Dracula',
            'path' => 'vendor/themes/dracula.css',
        ],
        'sunset' => [
            'name' => 'Sunset',
            'path' => 'vendor/themes/sunset.css',
        ],
        'travel' => [
            'name' => 'Travel',
            'path' => 'vendor/themes/travel.css',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Icon
    |--------------------------------------------------------------------------
    */

    'icon' => 'heroicon-o-swatch',

    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    */

    'default' => [
        'theme' => 'default',
        'theme_color' => 'blue',
    ],
];
