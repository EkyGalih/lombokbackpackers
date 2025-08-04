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

        #toTopBtn {
            transition: all 0.3s ease-in-out;
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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4762845598503420"
        crossorigin="anonymous"></script>
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
                    <img src="{{ app(\App\Settings\WebsiteSettings::class)->site_logo }}"
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
                    $tours = \App\Models\Tour::select('tours.*')
                        ->join('categories', 'categories.id', '=', 'tours.category_id')
                        ->with('category')
                        ->orderBy('categories.order')
                        ->orderBy('tours.order')
                        ->get()
                        ->groupBy(fn($item) => $item->category?->name ?? 'Tanpa Kategori');
                @endphp
                <ul class="space-y-2 text-sm">
                    @foreach ($tours as $categoryName => $tour)
                        @foreach ($tour as $item)
                            <li><a href="{{ route('tours.show', $item->slug) }}"
                                    class="hover:underline hover:text-cyan-300 transition-all duration-300">{{ $item->title }}</a>
                            </li>
                        @endforeach
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
            <div class="mt-4 text-center space-x-3">
                <a href="{{ url('/page/privacy-policy') }}" class="hover:underline hover:text-white/90">Privacy Policy</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('/page/terms-and-conditions') }}" class="hover:underline hover:text-white/90">Terms &
                    Conditions</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('/page/disclaimer') }}" class="hover:underline hover:text-white/90">Disclaimer</a>
            </div>

            &copy; {{ date('Y') }} {{ app(\App\Settings\WebsiteSettings::class)->site_name }}. All rights
            reserved.
        </div>
    </footer>

    <!-- Tombol WhatsApp dan Scroll to Top -->
    <div class="fixed bottom-5 right-5 flex flex-col items-center space-y-3 z-50">
        <!-- Tombol WhatsApp -->
        <a href="https://wa.me/{{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}" target="_blank"
            aria-label="Chat WhatsApp"
            class="bg-green-500 hover:bg-green-600 text-white rounded-full p-3 shadow-lg transition-transform hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="24" height="24"
                viewBox="0 0 24 24">
                <path
                    d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.157 5.3 5.478 0 12.058 0c3.2 0 6.2 1.24 8.476 3.514a11.848 11.848 0 0 1 3.507 8.413c-.003 6.627-5.384 12-12.01 12a11.9 11.9 0 0 1-5.65-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.593 5.448.003 9.888-4.43 9.89-9.872.002-5.462-4.413-9.89-9.881-9.893-5.462-.003-9.89 4.414-9.893 9.881a9.8 9.8 0 0 0 1.513 5.29l-.999 3.648 3.978-1.647zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.668.15-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.668-1.612-.916-2.206-.242-.579-.487-.5-.668-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.626.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.413z" />
            </svg>
        </a>

        <!-- Tombol Scroll to Top -->
        <!-- Tombol Scroll to Top -->
        <button id="toTopBtn"
            class="opacity-0 pointer-events-none fixed bg-teal-600 hover:bg-teal-700 text-white rounded-full p-3 shadow-lg transition-all duration-300 ease-in-out transform hover:scale-110"
            style="bottom: 5rem; right: 1.25rem; z-index: 50;" aria-label="Kembali ke atas">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="20" height="20" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </div>

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

    // Tampilkan tombol ke atas ketika scroll ke bawah
    const toTopBtn = document.getElementById("toTopBtn");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            toTopBtn.classList.remove("opacity-0", "pointer-events-none");
            toTopBtn.classList.add("opacity-100", "pointer-events-auto");
        } else {
            toTopBtn.classList.remove("opacity-100", "pointer-events-auto");
            toTopBtn.classList.add("opacity-0", "pointer-events-none");
        }
    });

    toTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
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
