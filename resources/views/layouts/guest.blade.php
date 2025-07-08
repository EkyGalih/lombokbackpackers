<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? '' . config('app.name') }}</title>
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
    </style>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-white text-gray-800 antialiased font-playfair">
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

    {{-- TOP BAR --}}
    <div x-data="{ scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
        :class="scrolled ? 'bg-white text-gray-800' : 'bg-transparent text-white'"
        class="text-sm py-2 px-6 w-full top-0 z-50 fixed transition-colors duration-300">

        <div class="container mx-auto flex justify-between items-center">
            <div class="space-x-4">
                <span>✉️ {{ app(\App\Settings\WebsiteSettings::class)->contact_email ?? 'info@travelnesia.com' }}</span>
                <span>📞 {{ app(\App\Settings\WebsiteSettings::class)->contact_phone ?? '0812-3456-7890' }}</span>
            </div>
            <div class="space-x-3">
                <a href="#" class="hover:underline">Facebook</a>
                <a href="#" class="hover:underline">Instagram</a>
                <a href="#" class="hover:underline">Twitter</a>
            </div>
        </div>
    </div>

    <!-- GARIS PEMISAH -->
    <div class="fixed top-[50px] w-full border-t border-white opacity-10 z-40"></div>

    <!-- HEADER -->
    <header x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
        :class="scrolled ? 'bg-white text-gray-800 shadow' : 'bg-transparent text-white'"
        class="w-full z-30 top-[36px] fixed transition-colors duration-300">

        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="text-2xl font-bold">
                {{ app(\App\Settings\WebsiteSettings::class)->site_name }}
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex space-x-8 items-center">
                @php
                    $menu = \App\Models\Navigations::whereNull('parent_id')
                        ->with(['childrenRecursive', 'parent'])
                        ->orderBy('order')
                        ->get();
                @endphp

                @if ($menu->isNotEmpty())
                    <ul class="flex space-x-4">
                        @foreach ($menu as $item)
                            <x-menu-item :item="$item" :depth="0" />
                        @endforeach
                    </ul>
                @endif

                @guest
                    <a href="{{ route('login') }}"
                        class="bg-orange-400 font-bold text-slate-900 px-5 py-2 rounded-lg shadow hover:bg-orange-300 transition ml-2">
                        Masuk
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}"
                        class="bg-orange-400 font-bold text-slate-900 px-5 py-2 rounded-lg shadow hover:bg-orange-300 transition ml-2">
                        My Account
                    </a>
                @endguest
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="open = !open" class="md:hidden focus:outline-none ml-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-transition @click.away="open = false"
            class="md:hidden px-6 pb-4 pt-2 space-y-2 bg-white text-gray-800 rounded-b-lg shadow">

            <a href="#paket" class="block py-2 px-3 rounded-lg hover:bg-cyan-600 hover:text-cyan-200 transition">
                Paket Tour
            </a>

            <a href="{{ route('login') }}"
                class="block py-2 px-3 rounded-lg hover:bg-cyan-600 hover:text-cyan-200 transition">
                Masuk
            </a>

            <a href="{{ route('register') }}"
                class="block bg-cyan-300 text-orange-950 px-5 py-2 rounded-lg mt-2 hover:bg-cyan-600 text-center shadow transition">
                Daftar
            </a>
        </div>
    </header>

    {{ $slot }}

    <footer class="bg-white py-6 text-center text-gray-500 text-sm mt-16">
        &copy; {{ now()->year }} {{ app(\App\Settings\WebsiteSettings::class)->site_name }}. All rights reserved.
    </footer>

</body>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
