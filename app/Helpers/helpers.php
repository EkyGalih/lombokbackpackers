<?php

if (!function_exists('imageOrDefault')) {
    function imageOrDefault(?string $url, string $type = 'default'): string
    {
        $defaults = [
            'default' => 'defaults/no-image.png',
            'card'    => 'defaults/no-image-card.png',
            'header'  => 'defaults/no-image-header.png',
            'avatar'  => 'defaults/no-avatar.png',
        ];

        $defaultPath = $defaults[$type] ?? $defaults['default'];

        if (empty($url)) {
            return asset($defaultPath);
        }

        // Ambil relative path dari URL
        $parsed = parse_url($url);
        $relativePath = ltrim($parsed['path'], '/'); // contoh: storage/media/…

        // Hapus prefix 'storage/' kalau file fisik ada di storage/app/public
        if (str_starts_with($relativePath, 'storage/')) {
            $relativePath = substr($relativePath, strlen('storage/'));
            $absolutePath = storage_path('app/public/' . $relativePath);
        } else {
            $absolutePath = public_path($relativePath);
        }

        if (is_file($absolutePath)) {
            return $url; // pakai URL asli
        }

        return asset($defaultPath);
    }
}
