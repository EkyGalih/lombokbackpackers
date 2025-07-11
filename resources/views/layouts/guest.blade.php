<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? '' . config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ app(\App\Settings\WebsiteSettings::class)->favicon }}">
    @yield('seoMeta')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .boat-container {
            animation: boat-sail 2s infinite ease-in-out;
        }

        @keyframes boat-sail {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-5px) rotate(-2deg);
            }

            50% {
                transform: translateY(0px) rotate(0deg);
            }

            75% {
                transform: translateY(5px) rotate(2deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 0;
            /* 👈 ini bikin jadi kotak */
            margin: 0 4px;
        }

        .swiper-pagination-bullet-active {
            background: #fff;
        }
    </style>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-white text-gray-800 text-sm antialiased font-playfair">
    {{-- Animasi boat loading --}}
    <div x-data="{ loaded: false }" x-init="window.addEventListener('load', () => loaded = true)" x-show="!loaded" x-transition.opacity.duration.2500ms
        class="fixed inset-0 bg-white z-50 flex justify-center items-center">
        <div class="boat-container">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="80" fill="#67e8f9">
                <path
                    d="M572.7 403.8c3.4 8.7-.7 18.6-9.5 22l-80 32c-2.6 1-5.3 1.6-8 1.6H100.8c-2.7 0-5.4-.5-8-1.6l-80-32c-8.7-3.4-12.9-13.3-9.5-22s13.3-12.9 22-9.5l76.2 30.5H474l76.2-30.5c8.7-3.4 18.6.8 22 9.5zM288 32c8.8 0 16 7.2 16 16v152h80c9.2 0 16.5 8.3 15.7 17.4l-16 176c-.8 8.5-7.9 14.6-16.3 14.6H208.6c-8.4 0-15.4-6.1-16.3-14.6l-16-176c-.9-9.1 6.5-17.4 15.7-17.4h80V48c0-8.8 7.2-16 16-16z" />
            </svg>
        </div>
    </div>
    {{-- Animasi boat loading --}}
    {{ $nav ?? '' }}

    {{ $slot }}

    <footer class="bg-teal-900 text-white py-6">
        <div class="container mx-auto px-4 flex flex-col md:flex-row md:justify-between md:items-center">
            <!-- Kolom kiri: Gambar -->
            <div class="mb-4 md:mb-0 flex items-center space-x-3">
                <img src="{{ app(\App\Settings\WebsiteSettings::class)->site_logo }}" alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? ENV('APP_NAME') }}" class="h-10 w-10 object-contain rounded-full bg-white/80 p-1 mr-4 shadow>
                <span class="font-bold text-lg">{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? env('APP_NAME') }}</span>
            </div>

            <!-- Kolom kanan: Informasi -->
            <div class="text-sm space-y-1">
                <p>&copy; 2025 {{ app(\App\Settings\WebsiteSettings::class)->site_name }}. All rights reserved.</p>
                <p>
                    <a href="#" class="hover:underline">Privacy Policy</a> |
                    <a href="#" class="hover:underline">Terms of Service</a>
                </p>
                <p>Contact: {{ app(\App\Settings\WebsiteSettings::class)->contact_email }} |
                    {{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}</p>
            </div>
        </div>
    </footer>

</body>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });
    });
</script>

@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

</html>
