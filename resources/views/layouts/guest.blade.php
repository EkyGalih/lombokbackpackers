<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? '' . config('app.name') }}</title>
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
</head>

<body class="bg-white text-gray-800 antialiased">
    {{-- Animasi boat loading --}}
    <div x-data="{ loaded: false }" x-init="window.addEventListener('load', () => loaded = true)" x-show="!loaded" x-transition.opacity.duration.2500ms
        class="fixed inset-0 bg-white z-50 flex justify-center items-center">
        <div class="boat-container">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="80" fill="#4F46E5">
                <path
                    d="M572.7 403.8c3.4 8.7-.7 18.6-9.5 22l-80 32c-2.6 1-5.3 1.6-8 1.6H100.8c-2.7 0-5.4-.5-8-1.6l-80-32c-8.7-3.4-12.9-13.3-9.5-22s13.3-12.9 22-9.5l76.2 30.5H474l76.2-30.5c8.7-3.4 18.6.8 22 9.5zM288 32c8.8 0 16 7.2 16 16v152h80c9.2 0 16.5 8.3 15.7 17.4l-16 176c-.8 8.5-7.9 14.6-16.3 14.6H208.6c-8.4 0-15.4-6.1-16.3-14.6l-16-176c-.9-9.1 6.5-17.4 15.7-17.4h80V48c0-8.8 7.2-16 16-16z" />
            </svg>
        </div>
    </div>
    {{-- Animasi boat loading --}}
    <header x-data="{ open: false }" class="bg-white shadow-md fixed w-full z-50 top-0">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <a href="{{ url('/') }}"
                class="text-2xl font-bold text-indigo-600">{{ app(\App\Settings\WebsiteSettings::class)->site_name }}</a>

            <div class="hidden md:flex space-x-8 items-center">
                @php
                    $menus = \App\Models\Menu::whereNull('parent_id')
                        ->where('active', true)
                        ->orderBy('sort_order')
                        ->get();
                @endphp
                @foreach ($menus as $menu)
                    <div class="relative group">
                        <a href="{{ $menu->url }}"
                            class="text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-2 py-1 rounded-lg flex items-center">
                            {{ $menu->title }}
                            @if ($menu->children->count())
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </a>
                        @if ($menu->children->count())
                            <div
                                class="absolute left-0 mt-2 w-40 bg-white border rounded-lg shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-50">
                                @foreach ($menu->children as $child)
                                    <a href="{{ $child->url }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-colors duration-200">
                                        {{ $child->title }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
                <a href="#paket"
                    class="text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-2 py-1 rounded-lg">Paket
                    Tour</a>
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition-colors duration-200 ml-2">
                        Masuk
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition-colors duration-200 ml-2">
                        My Account
                    </a>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <button @click="open = !open" class="md:hidden text-gray-700 focus:outline-none ml-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" @click.away="open = false"
            class="md:hidden px-6 pb-4 pt-2 space-y-2 bg-white rounded-b-lg shadow">
            <a href="#paket"
                class="block text-gray-700 py-2 px-3 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">Paket
                Tour</a>
            <a href="{{ route('login') }}"
                class="block text-gray-700 py-2 px-3 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">Masuk</a>
            <a href="{{ route('register') }}"
                class="block bg-indigo-600 text-white px-5 py-2 rounded-lg mt-2 hover:bg-indigo-700 text-center shadow transition-colors duration-200">
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
