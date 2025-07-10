<x-guest-layout>
    <x-slot name="nav">
        <div class="text-sm py-2 px-4 w-full bg-white text-teal-900">
            <div class="container mx-auto flex justify-between items-center">
                <div class="space-x-4">
                    ✉️ {{ app(\App\Settings\WebsiteSettings::class)->contact_email ?? 'info@travelnesia.com' }}
                    📞 {{ app(\App\Settings\WebsiteSettings::class)->contact_phone ?? '0812-3456-7890' }}
                </div>
                <div class="space-x-3">
                    <a href="#" class="hover:underline">Facebook</a>
                    <a href="#" class="hover:underline">Instagram</a>
                    <a href="#" class="hover:underline">Twitter</a>
                </div>
            </div>
        </div>

        <!-- GARIS PEMISAH -->
        <div class="top-[50px] w-full border-t border-teal-900 opacity-10 z-40"></div>

        {{-- HEADER --}}
        <header class="w-full bg-white text-teal-900 transition-colors duration-300">
            <div class="container mx-auto flex justify-between items-center px-6 py-4">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-teal-900">
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
                            class="bg-lime-300 text-slate-900 px-5 py-2 rounded-br-3xl rounded-lg shadow hover:bg-lime-200 transition ml-2">
                            Masuk
                        </a>
                    @else
                        <a href="{{ route('profile.edit') }}"
                            class="bg-lime-300 text-slate-900 px-5 py-2 rounded-lg shadow hover:bg-lime-200 transition ml-2">
                            My Account
                        </a>
                    @endguest
                </div>

                {{-- Mobile --}}
                <div x-show="open" x-transition @click.away="open = false"
                    class="md:hidden px-6 pb-4 pt-2 space-y-2 bg-white text-gray-800 rounded-b-lg shadow">

                    <a href="#paket"
                        class="block py-2 px-3 rounded-lg hover:bg-cyan-600 hover:text-cyan-200 transition">
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
            </div>
        </header>
        <section class="relative h-44 overflow-hidden">
            {{-- Background Gambar --}}
            <img src="{{ app(\App\Settings\WebsiteSettings::class)->header_image }}"
                alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name }}"
                class="absolute inset-0 w-full h-full object-cover opacity-50 filter blur-sm z-0">

            {{-- Overlay warna gradasi --}}
            <div class="absolute inset-0 bg-gradient-to-br from-teal-950/60 to-teal-950/80 z-0"></div>

            {{-- Konten --}}
            <div class="relative z-10 h-full flex items-start justify-start">
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)" x-show="show"
                    x-transition:enter="transform opacity-0 -translate-x-full"
                    x-transition:enter-end="transform opacity-100 translate-x-0" x-transition:enter.duration.1000ms
                    x-cloak class="p-8 md:p-16">
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-1 text-white drop-shadow-lg">
                        Destinasi Wisata
                    </h1>
                    <p class="text-xs md:text-sm font-semibold text-white drop-shadow">
                        Home > Destinasi Wisata
                    </p>
                </div>
            </div>
        </section>

    </x-slot>
    {{-- Paket Tour Section --}}
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">

            @if ($categories->count())
                <div class="container mx-auto px-6 py-12 grid md:grid-cols-3 gap-8">

                    <!-- Kolom Kiri: Destinasi -->
                    <div class="md:col-span-2 grid md:grid-cols-2 gap-6">
                        @foreach ($categories as $category)
                            <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg transform transition-all ease-in-out duration-1000 hover:shadow-none hover:custom-rounded-br"
                                style="--tw-rounded-br: 60px;">
                                {{-- Gambar full --}}
                                <div class="overflow-hidden"> {{-- Tambahkan pembungkus supaya crop gambar ketika zoom --}}
                                    <img src="{{ $category->media?->first()->url }}" alt="{{ $category->name }}"
                                        class="w-full h-[600px] object-cover transform transition-transform duration-1000 ease-in-out group-hover:scale-110">
                                </div>

                                {{-- Overlay tulisan di bawah --}}
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 z-20">
                                    <div
                                        class="transition-transform duration-1000 ease-in-out transform group-hover:-translate-y-8">
                                        <h3 class="text-lg font-semibold text-white">
                                            {{ $category->name }}
                                        </h3>

                                        @if ($category->discount && $category->discount > 0)
                                            <p class="text-sm text-gray-300 line-through">
                                                Rp {{ number_format($category->toures->lowest_price, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xl text-red-400 font-bold">
                                                Rp
                                                {{ number_format($category->price - $category->discount, 0, ',', '.') }}
                                            </p>
                                            <small class="text-gray-300 text-xs">{{ $category->package_person_count }}
                                                Person</small>
                                        @else
                                            <p class="text-xl font-semibold text-indigo-300">
                                                Rp {{ number_format($category->lowest_price, 0, ',', '.') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Tombol Book Now tampil saat hover --}}
                                <div
                                    class="absolute bottom-4 left-0 right-0 flex justify-center opacity-0 group-hover:opacity-100 transform translate-y-6 group-hover:translate-y-0 transition-all duration-1000 ease-in-out z-30">
                                    <a href="{{ route('categories.show', $category->slug) }}"
                                        class="bg-transparent px-4 py-2 rounded text-white text-sm font-semibold shadow underline hover:underline-offset-1 transition">
                                        Browse Trips
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Kolom Kanan: Sidebar -->
                    <div class="space-y-4 space-x-8">

                        <!-- Destinations -->
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h1 class="font-bold text-left mb-4 text-lg md:text-3xl">Destinations</h1>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($categories as $dest)
                                    <button
                                        class="bg-teal-900 text-white text-sm px-6 py-2 rounded-lg rounded-br-3xl hover:rounded-br-lg transition-all duration-500 hover:bg-lime-400 hover:text-slate-900">{{ $dest->name }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Belum ada paket tour tersedia.</p>
            @endif

        </div>
    </section>
</x-guest-layout>
