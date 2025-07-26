<x-guest-layout>
    <x-slot name="nav">
        <x-header title="{{ __('destination.title') }}"
            breadcrumb="{{ __('destination.breadcrumb') }} > {{ $category->name }}"
            image="{{ imageOrDefault($category->media?->first()?->url, 'header') }}" alt="{{ $category->name }}" />
    </x-slot>

    {{-- Paket Tour Section --}}
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                {{-- Kiri: Nama & deskripsi kategori --}}
                <div>
                    @if ($tours_by_category->count())
                        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
                            @foreach ($tours_by_category as $tour)
                                <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg transform transition-all ease-in-out duration-700 hover:shadow-none hover:custom-rounded-br"
                                    style="--tw-rounded-br: 100px;">

                                    {{-- Gambar --}}
                                    <div class="overflow-hidden h-64">
                                        <img src="{{ imageOrDefault($tour->media?->first()?->url, 'card') }}"
                                            alt="{{ $tour->title }}"
                                            class="w-full h-full object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110">
                                    </div>

                                    {{-- Overlay --}}
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 flex flex-col gap-1">
                                        <h3 class="text-lg font-semibold text-white">
                                            {{ $tour->title }}
                                        </h3>
                                        <p class="text-sm font-semibold text-white">
                                            {{ __('destination.price') }}:
                                            {{ $category->formatCurrency($tour->lowest_price) }}
                                            -
                                            {{ $category->formatCurrency($tour->highest_price) }}
                                        </p>
                                        <a href="{{ route('tours.show', $tour->slug) }}"
                                            class="inline-block text-white font-bold underline">
                                            {{ __('button.trips') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center">Belum ada paket tour tersedia.</p>
                    @endif
                </div>

                {{-- Kanan: Grid card destinasi --}}
                <div class="space-y-4">
                    <h2 class="text-3xl md:text-4xl font-bold text-cyan-950">
                        {{ $category->name }}sss
                    </h2>
                    <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                        {!! $category->description !!}
                    </p>
                </div>

            </div>
        </div>
    </section>
</x-guest-layout>
