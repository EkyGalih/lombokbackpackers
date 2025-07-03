<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Travelnesia') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800 antialiased">
    <header x-data="{ open: false }" class="bg-white shadow-md fixed w-full z-50 top-0">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600">Travelnesia</a>

            <div class="hidden md:flex space-x-8 items-center">
                @php
                    $menus = \App\Models\Menu::whereNull('parent_id')
                        ->where('active', true)
                        ->orderBy('sort_order')
                        ->get();
                @endphp
                <ul>
                    @foreach ($menus as $menu)
                        <li>
                            <a href="{{ $menu->url }}">{{ $menu->title }}</a>

                            @if ($menu->children->count())
                                <ul>
                                    @foreach ($menu->children as $child)
                                        <li><a href="{{ $child->url }}">{{ $child->title }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <a href="#paket"
                    class="text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-2 py-1 rounded-lg">Paket
                    Tour</a>
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition-colors duration-200 ml-2">
                        Masuk
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
        &copy; {{ now()->year }} Travelnesia. All rights reserved.
    </footer>

</body>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</html>
