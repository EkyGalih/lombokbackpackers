<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? '' . config('app.name') }}</title>
    <link rel="icon" type="image/png"
        href="{{ imageOrDefault(asset(app(\App\Settings\WebsiteSettings::class)->favicon), 'header') }}">
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
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@400;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-white text-gray-800 text-sm antialiased font-sans">
    {{-- Animasi plane loading --}}
    {{-- <div x-data="{ loaded: false }" x-init="window.addEventListener('load', () => loaded = true)" x-show="!loaded" x-transition.opacity.duration.1500ms
        class="fixed inset-0 bg-white z-50 flex justify-center items-center">
        <div class="plane-container animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="100" fill="#38bdf8">
                <path
                    d="M480 192H365.71L260.61 8.48A16 16 0 00247.71 0h-32a16 16 0 00-14.24 8.48L189.68 64H112a16 16 0 00-16 16v32a16 16 0 0016 16h48.32l41.79 160H96l-27.13-54.27A16 16 0 0055.71 208H24a16 16 0 00-14.24 23.52l72 144A16 16 0 0096 384h96.11l40.8 160H352l105.09-183.52A32 32 0 00480 320V208a16 16 0 00-16-16z" />
            </svg>
        </div>
    </div> --}}
    {{-- Animasi plane loading --}}
    {{ $nav ?? '' }}

    {{ $slot }}

    <footer class="bg-gradient-to-r from-teal-900 to-cyan-900 text-white py-10 relative overflow-hidden">
        <div class="absolute inset-0 bg-teal-800/20 backdrop-blur-sm"></div>

        <div
            class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 animate-fade-in">
            {{-- Kolom 1: Branding --}}
            <div>
                <div class="flex items-center mb-4 space-x-3">
                    <img src="{{ imageOrDefault(asset(app(\App\Settings\WebsiteSettings::class)->site_logo), 'header') }}"
                        alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? ENV('APP_NAME') }}"
                        class="h-12 w-12 object-contain rounded-full bg-white/90 p-1 shadow transition-transform hover:scale-110">
                    <span class="text-2xl font-bold">
                        {{ app(\App\Settings\WebsiteSettings::class)->site_name ?? env('APP_NAME') }}
                    </span>
                </div>
                <p class="text-sm text-gray-200">
                    {{ app(\App\Settings\WebsiteSettings::class)->header_title ?? 'Your trusted travel partner.' }}
                </p>
            </div>

            {{-- Kolom 2: Links --}}
            <div>
                <h4 class="text-lg font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#"
                            class="hover:underline hover:text-cyan-300 transition-all duration-300">Home</a></li>
                    <li><a href="#"
                            class="hover:underline hover:text-cyan-300 transition-all duration-300">Tours</a></li>
                    <li><a href="#"
                            class="hover:underline hover:text-cyan-300 transition-all duration-300">Bookings</a></li>
                    <li><a href="#"
                            class="hover:underline hover:text-cyan-300 transition-all duration-300">Contact</a></li>
                    <li><a href="#" class="hover:underline hover:text-cyan-300 transition-all duration-300">About
                            Us</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Contact --}}
            <div>
                <h4 class="text-lg font-semibold mb-3">Contact</h4>
                <p class="text-sm">📧 {{ app(\App\Settings\WebsiteSettings::class)->contact_email }}</p>
                <p class="text-sm">📞 {{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}</p>
                <p class="text-sm mt-2">🌏 Follow us:</p>
                <div class="flex space-x-3 mt-2">
                    <a href="#"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-cyan-600 transition-transform transform hover:rotate-12">
                        <svg class="w-4 h-4" fill="currentColor">
                            <use xlink:href="#icon-facebook"></use>
                        </svg>
                    </a>
                    <a href="#"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-cyan-600 transition-transform transform hover:-rotate-12">
                        <svg class="w-4 h-4" fill="currentColor">
                            <use xlink:href="#icon-twitter"></use>
                        </svg>
                    </a>
                    <a href="#"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-cyan-600 transition-transform transform hover:rotate-12">
                        <svg class="w-4 h-4" fill="currentColor">
                            <use xlink:href="#icon-instagram"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="relative z-10 mt-10 border-t border-teal-700 pt-4 text-center text-sm text-gray-300">
            &copy; {{ date('Y') }} {{ app(\App\Settings\WebsiteSettings::class)->site_name }}. All rights
            reserved.
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
