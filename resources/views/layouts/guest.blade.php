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
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-46ELV7K7Q9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-46ELV7K7Q9');
    </script>
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

    <footer class="relative overflow-hidden text-white py-10"
        style="background-image: url('{{ app(\App\Settings\WebsiteSettings::class)->header_image }}'); background-size: cover; background-position: center;">

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-teal-900/80 backdrop-blur-sm"></div>

        <div
            class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 animate-fade-in">
            {{-- Branding --}}
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

            {{-- Links --}}
            <div>
                <h4 class="text-lg font-semibold mb-3">Quick Links</h4>
                @php
                    $tour = \App\Models\Tour::latest()->take(5)->get();
                @endphp
                <ul class="space-y-2 text-sm">
                    @foreach ($tour as $item)
                        <li><a href="{{ route('tours.show', $item->slug) }}"
                                class="hover:underline hover:text-cyan-300 transition-all duration-300">{{ $item->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-lg font-semibold mb-3">Contact</h4>
                <p class="text-sm">📧 {{ app(\App\Settings\WebsiteSettings::class)->contact_email }}</p>
                <p class="text-sm">📞 {{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}</p>
                <p class="text-sm mt-2">🌏 {{ __('contactUs.follow') }}:</p>
                <div class="flex space-x-3 mt-2">
                    {{-- sosial media icons… --}}
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
        // SLIDER untuk Why Us → selalu aktif
        new Swiper('.swiper-whyus', {
            slidesPerView: 1,
            spaceBetween: 16,
            pagination: {
                el: '.swiper-pagination-whyus',
                clickable: true
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            loop: true
        });

        // SLIDER untuk Popular Trips → hanya untuk mobile
        if (window.innerWidth < 768) {
            new Swiper('.swiper-popular', {
                slidesPerView: 1,
                spaceBetween: 16,
                pagination: {
                    el: '.swiper-pagination-popular',
                    clickable: true
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false
                },
                loop: true
            });
        }
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
