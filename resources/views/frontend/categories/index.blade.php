<x-guest-layout>
    <x-slot name="nav">
        <x-header title="Destinasi Wisata" breadcrumb="Destinasi Wisata" />
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
                                <div class="overflow-hidden">
                                    <img src="{{ imageOrDefault($category->media?->first()?->url, 'card') }}" alt="{{ $category->name }}"
                                        class="w-full h-[600px] object-cover transform transition-transform duration-1000 ease-in-out group-hover:scale-110">
                                </div>

                                {{-- Overlay teks & tombol --}}
                                <div class="absolute bottom-0 left-0 right-4 z-20 text-white">
                                    {{-- Container teks + tombol di pojok kiri bawah --}}
                                    <div class="relative space-y-1">
                                        {{-- Teks kategori & harga --}}
                                        <div
                                            class="transition-all duration-700 ease-in-out transform group-hover:-translate-y-6">
                                            <h3 class="text-lg font-semibold">
                                                {{ $category->name }}
                                            </h3>

                                            <p class="text-xl font-semibold">
                                                Harga Mulai (Rp.
                                                {{ number_format($category->price_range['min']) . ' - ' . number_format($category->price_range['max']) }})
                                            </p>
                                        </div>

                                        {{-- Tombol Browse Trips di pojok kiri bawah --}}
                                        <div
                                            class="opacity-0 group-hover:opacity-100 group-hover:translate-y-0 translate-y-2 transition-all duration-700 ease-in-out">
                                            <a href="{{ route('categories.show', $category->slug) }}"
                                                class="inline-block mt-1 px-1 py-1 rounded borde text-white text-lg font-bold underline transition">
                                                Browse Trips
                                            </a>
                                        </div>
                                    </div>
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
