<x-guest-layout>
    <x-slot name="nav">
        <x-header title="Destinasi Wisata" breadcrumb="Destination > {{ $category->name }}"
            image="{{ imageOrDefault($category->media?->first()->url, 'header') }}" alt="{{ $category->name }}" />
    </x-slot>
    {{-- Paket Tour Section --}}
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">

            @if ($tours_by_category->count())
                <div class="grid gap-6 md:grid-cols-4" id="paket">
                    @foreach ($tours_by_category as $tour)
                        <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg transform transition-all ease-in-out duration-700 hover:shadow-none hover:custom-rounded-br"
                            style="--tw-rounded-br: 100px;">

                            {{-- Gambar full --}}
                            <div class="overflow-hidden"> {{-- Tambahkan pembungkus supaya crop gambar ketika zoom --}}
                                <img src="{{ imageOrDefault($tour->media?->first()->url, 'card') }}" alt="{{ $tour->title }}"
                                    class="w-full h-[500px] object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110">
                            </div>

                            {{-- Overlay tulisan di bawah --}}
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t transition-all duration-500 ease-in-out group-hover:-translate-y-6 from-black/80 to-transparent p-4 mb-4flex flex-col gap-1">
                                <h3 class="text-lg font-semibold text-white">
                                    {{ $tour->title }}
                                </h3>

                                <p
                                    class="text-xl font-semibold text-white transition-all duration-700 ease-in-out group-hover:-translate-y-2 group-hover:text-lime-300">
                                    Harga Mulai (Rp. {{ number_format($tour->lowest_price) }} -
                                    {{ number_format($tour->highest_price) }})
                                </p>

                                <a href="{{ route('tours.show', $tour->slug) }}"
                                    class="inline-block opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 text-white font-bold underline transition-all duration-1000 ease-in-out">
                                    Browse Trips
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Belum ada paket tour tersedia.</p>
            @endif

        </div>
    </section>
</x-guest-layout>
