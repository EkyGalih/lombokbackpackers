<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>
        @hasSection('title')
            @yield('title') - {{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}
        @else
            {{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}
        @endif
    </title>
    <link rel="icon" type="image/png"
        href="{{ asset('storage/' . app(\App\Settings\WebsiteSettings::class)->favicon) ?? asset('defaults/no-image.png') }}">
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
            background: rgba(255, 255, 255, 0.3);
            /* lebih samar dari 0.5 */
            border-radius: 0;
            /* kotak */
            margin: 0 4px;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: rgba(255, 255, 255, 0.8);
            /* lebih jelas */
        }

        .swiper-pagination {
            bottom: 0px;
            /* default */
        }

        .swiper-pagination {
            bottom: -20px;
            /* lebih ke bawah */
        }

        .swiper-button-prev,
        .swiper-button-next {
            color: #000;
            opacity: 0.3;
            transition: all 0.3s ease;
        }

        .swiper-button-prev:hover,
        .swiper-button-next:hover {
            opacity: 0.8;
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
                            class="hover:underline hover:text-cyan-300 transition-all duration-300">Destinations</a>
                    </li>
                    <li><a href="#" class="hover:underline hover:text-cyan-300 transition-all duration-300">About
                            Us</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Contact --}}
            <div>
                <h4 class="text-lg font-semibold mb-3">Contact</h4>
                <p class="text-sm">📧 {{ app(\App\Settings\WebsiteSettings::class)->contact_email }}</p>
                <p class="text-sm">📞 {{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}</p>
                <p class="text-sm mt-2">🌏 {{ __('contactUs.follow') }}:</p>
                <div class="flex space-x-3 mt-2">
                    <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_facebook }}"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-cyan-600 transition-transform transform hover:rotate-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12c0-5.5228-4.4772-10-10-10S2 6.4772 2 12c0 5.0027 3.657 9.128 8.438 9.878V15.47H7.898v-3.47h2.54v-2.644c0-2.5078 1.493-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.24 0-1.627.77-1.627 1.562V12h2.773l-.443 3.47h-2.33v6.407C18.343 21.128 22 17.003 22 12Z" />
                        </svg>
                    </a>
                    <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_x }}"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-cyan-600 transition-transform transform hover:-rotate-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M4.54 3h4.74l3.27 4.98L16.03 3h3.43l-5.52 7.49L20.74 21h-4.74l-3.6-5.46L8.03 21H4.6l5.74-7.8L4.54 3Zm3.13 1.08L15.19 20h1.14L8.83 4.08H7.67Z" />
                        </svg>
                    </a>
                    <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_instagram }}"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-cyan-600 transition-transform transform hover:rotate-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M7 2C4.239 2 2 4.239 2 7v10c0 2.761 2.239 5 5 5h10c2.761 0 5-2.239 5-5V7c0-2.761-2.239-5-5-5H7Zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10ZM12 7c-2.757 0-5 2.243-5 5s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5Zm0 2c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3Zm4.5-3a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
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
                delay: 9000,
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
