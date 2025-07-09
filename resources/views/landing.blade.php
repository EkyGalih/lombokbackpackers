<x-guest-layout>
    {{-- Hero Section --}}
    @php
        $headerImage = app(\App\Settings\WebsiteSettings::class)->header_image;
        $headerTitle = app(\App\Settings\WebsiteSettings::class)->header_title;
        $headerSubTitle = app(\App\Settings\WebsiteSettings::class)->header_sub_title;
    @endphp
    <div x-data="{
        activeTab: 'adventure',
        showModal: false,
        modalIndex: 0,
        images: {
            adventure: [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'
            ],
            vacations: [
                'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                'https://images.unsplash.com/photo-1493558103817-58b2924bce98?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'
            ],
            hills: [
                'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'
            ],
            seasonal: [
                'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'
            ]
        }
    }" class="relative">

        {{-- MODAL GAMBAR --}}
        <div x-show="showModal" x-transition.opacity
            class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">
            <div class="relative bg-transparent rounded-lg shadow-lg h-full w-full overflow-hidden">

                <!-- Tombol close di luar gambar -->
                <button @click="showModal = false"
                    class="absolute top-4 right-4 text-white text-3xl z-20">&times;</button>

                <!-- Gambar + panah -->
                <div class="relative flex items-center justify-center h-full w-full">
                    <img :src="images[activeTab][modalIndex]" alt="" class="w-96 h-96 object-cover rounded-lg">

                    <!-- Tombol prev -->
                    <button @click="modalIndex = (modalIndex - 1 + images[activeTab].length) % images[activeTab].length"
                        class="absolute left-8 top-1/2 transform -translate-y-1/2 text-white text-4xl bg-transparent rounded-full w-10 h-10 flex items-center justify-center z-10">
                        &#10094;
                    </button>

                    <!-- Tombol next -->
                    <button @click="modalIndex = (modalIndex + 1) % images[activeTab].length"
                        class="absolute right-8 top-1/2 transform -translate-y-1/2 text-white text-4xl bg-transparent rounded-full w-10 h-10 flex items-center justify-center z-10">
                        &#10095;
                    </button>
                </div>

            </div>
        </div>

        <section
            class="h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-900 to-cyan-900 text-white relative overflow-hidden">

            @if ($headerImage)
                <img src="{{ asset('storage/' . $headerImage) }}" alt="Header Image"
                    class="absolute inset-0 w-full h-full object-cover opacity-30 z-0 bg-cover bg-center">
            @endif

            <div class="text-center z-10 px-4 max-w-3xl">
                <h1
                    class="text-4xl md:text-6xl font-bold mb-4 bg-gradient-to-r from-white to-lime-300 bg-clip-text text-transparent">
                    {{ $headerTitle }}
                </h1>
                <p class="text-lg md:text-xl mb-8">
                    {{ $headerSubTitle }}
                </p>

                <div class="flex justify-center gap-4 mb-16 relative h-32">
                    <template x-for="(img, index) in images[activeTab]" :key="activeTab + '-' + index">
                        <div
                            class="relative group w-52 h-40 rounded-md shadow-md overflow-hidden border border-transparent transition-transform duration-500 ease-in-out group-hover:scale-110 hover:border-orange-400 hover:rounded-br-full">
                            <img :src="img" alt=""
                                class="w-full h-full object-cover rounded-md opacity-0 animate-fade-in-up transform transition-transform duration-300 group-hover:scale-105"
                                x-init="$el.classList.remove('opacity-0')">

                            <button @click="showModal = true; modalIndex = index"
                                class="absolute inset-0 flex items-center bg-gradient-to-r from-black/50 to-black/50 justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white z-20" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
                <a href="#"
                    class="bg-lime-300 text-slate-900 font-semibold px-6 py-3 rounded-lg shadow hover:bg-lime-200 transition">
                    Explore More
                </a>
            </div>
            {{-- TABS --}}
            <div class="z-30 flex flex-wrap justify-center mt-12 gap-4 px-4">
                <template
                    x-for="tab in [
                {key: 'adventure', label: '01. Adventure'},
                {key: 'vacations', label: '02. Vacations'},
                {key: 'hills', label: '03. Hills Station'},
                {key: 'seasonal', label: '04. Seasonal'}
            ]">
                    <button @click="activeTab = tab.key"
                        :class="activeTab === tab.key ?
                            'bg-lime-300 text-slate-900' :
                            'bg-white bg-opacity-20 text-white'"
                        class="font-semibold px-8 py-3 rounded w-72 text-center mt-12" x-text="tab.label"></button>
                </template>
            </div>

            {{-- Optional Background Illustration --}}
            {{-- <div class="absolute inset-0 bg-cover bg-center opacity-20"
                style="background-image: url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
            </div> --}}
        </section>
    </div>

    {{-- Paket Tour Section --}}
    <section class="bg-sky-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-sm font-semibold tracking-widest text-cyan-950 uppercase mb-2">
                Paket Tour Unggulan
            </h2>
            <h2 class="text-6xl font-black mb-8 text-cyan-950 leading-tight tracking-tight">
                Pilih Paket Perjalananmu
            </h2>

            @if (\App\Models\Tour::count())
                <div class="grid gap-6 md:grid-cols-4" id="paket">
                    @foreach (\App\Models\Tour::take(4)->get() as $tour)
                        <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg transform transition-all ease-in-out duration-300 hover:shadow-none hover:custom-rounded-br"
                            style="--tw-rounded-br: 60px;">

                            {{-- Gambar full --}}
                            <div class="overflow-hidden"> {{-- Tambahkan pembungkus supaya crop gambar ketika zoom --}}
                                <img src="{{ $tour->media?->first()->url }}" alt="{{ $tour->title }}"
                                    class="w-full h-96 object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110">
                            </div>

                            {{-- Overlay tulisan di bawah --}}
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 z-20">
                                <div class="transition-transform duration-300 ease-out group-hover:scale-105">
                                    <h3 class="text-lg font-semibold text-white">
                                        {{ $tour->title }}
                                    </h3>

                                    @if ($tour->discount && $tour->discount > 0)
                                        <p class="text-sm text-gray-300 line-through">
                                            Rp {{ number_format($tour->lowest_price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xl text-red-400 font-bold">
                                            Rp {{ number_format($tour->lowest_price - $tour->discount, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-xl font-semibold text-lime-400">
                                            Rp {{ number_format($tour->lowest_price, 0, ',', '.') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Tombol Book Now tampil saat hover --}}
                            <div
                                class="absolute inset-0 flex justify-center items-center opacity-0 group-hover:opacity-100 bg-black bg-opacity-50 transition duration-300 z-10">
                                <a href="{{ route('tours.show', $tour->slug) }}"
                                    class="text-white text-lg font-bold underline hover:text-white transition">
                                    Browse Trips
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tambahkan tombol di bawah --}}
                <div class="mt-10">
                    <a href="{{ route('tours.index') }}"
                        class="inline-block bg-lime-300 text-slate-900 px-6 py-3 rounded-lg shadow hover:bg-lime-200 transition">
                        Explore All Destinations
                    </a>
                </div>
            @else
                <p class="text-gray-500">Belum ada paket tour tersedia.</p>
            @endif

        </div>
    </section>

    {{-- Why Us Section --}}
    <section class="bg-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-sm font-semibold tracking-widest text-cyan-950 uppercase mb-2">
                Kenapa Memilih Kami
            </h2>
            <h2 class="text-5xl font-black mb-8 text-cyan-950 leading-tight tracking-tight">
                Pengalaman Perjalanan Terbaik
            </h2>
            @php
                $features = \App\Models\Features::limit(6)->get();
            @endphp
            <section class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                {{-- Fitur kiri --}}
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($features as $feature)
                            <div
                                class="relative group text-white p-4 rounded overflow-hidden bg-teal-900 hover:bg-lime-500 rounded-br-lg hover:rounded-br-3xl hover:rounded-tl-3xl transition-all duration-500 ease-in-out min-h-64">

                                {{-- Background --}}
                                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30
                transition-all duration-500 ease-in-out scale-105 group-hover:scale-100"
                                    style="background-image: url('{{ $feature->media->first()->url }}');">
                                </div>

                                {{-- Content --}}
                                <div
                                    class="relative z-10 flex flex-col justify-center h-full transition-all duration-500 ease-in-out group-hover:-translate-y-1">

                                    {{-- ICON --}}
                                    <div
                                        class="text-3xl mb-4 transition-all duration-500 ease-in-out opacity-100 group-hover:opacity-50">
                                        <img class="w-24 h-24 object-cover rounded-full mx-auto mb-2 border-2 border-lime-300 shadow-lg"
                                            src="{{ $feature->media?->first()->url }}" alt="{{ $feature['title'] }}">
                                    </div>

                                    {{-- Title --}}
                                    <h3
                                        class="font-bold text-lg transition-all duration-500 ease-in-out group-hover:text-white group-hover:scale-105">
                                        {{ $feature['title'] }}
                                    </h3>

                                    {{-- Description --}}
                                    <p
                                        class="text-sm transition-all duration-500 ease-in-out group-hover:text-gray-100 group-hover:scale-105">
                                        {!! $feature['description'] !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- Slider kanan --}}
                <div>
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @foreach ([
        [
            'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'Pantai Indah',
            'description' => 'Liburan di pantai tropis.',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'Gunung Megah',
            'description' => 'Pendakian penuh petualangan.',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'Kota Bersejarah',
            'description' => 'Wisata budaya & sejarah.',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ],
    ] as $slide)
                                <div class="swiper-slide relative">
                                    <img src="{{ $slide['image'] }}" class="w-full h-80 object-cover rounded-lg h-96">
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <h2 class="text-2xl font-bold">{{ $slide['title'] }}</h2>
                                        <p>{{ $slide['description'] }}</p>
                                        <p>{{ $slide['start_date']->format('d M') }} -
                                            {{ $slide['end_date']->format('d M') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination absolute top-2 right-2 z-10"></div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-teal-800 mb-10">
                Wisata Populer
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card 1 -->
                <a href="https://wdtletsgo.wpengine.com/blog/wdt_packages/egypt-pyramids-tour/"
                    class="relative rounded-lg overflow-hidden shadow-lg group">
                    <img src="https://wdtletsgo.wpengine.com/wp-content/uploads/2024/07/egypt-3.jpg" alt=""
                        class="w-full h-64 object-cover transition-transform group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">

                        <!-- Info -->
                        <div class="transition-all duration-300 group-hover:-translate-y-6">
                            <h3 class="text-lg font-semibold text-white">Egypt Pyramids Tour</h3>
                            <ul class="text-sm text-gray-200 space-y-1">
                                <li>Starts from - $39.00</li>
                                <li>6 Days - 4 Nights</li>
                                <li>All New Year (Mar - May)</li>
                            </ul>
                        </div>

                        <!-- Tombol muncul saat hover -->
                        <span
                            class="opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 inline-block mt-1">
                            <button class="px-3 py-1 text-sm bg-teal-600 text-white rounded hover:bg-teal-700">
                                Explore Trip →
                            </button>
                        </span>

                    </div>
                </a>

                <!-- Card 2 -->
                <a href="https://wdtletsgo.wpengine.com/blog/wdt_packages/usa-grand-explorer/"
                    class="relative rounded-lg overflow-hidden shadow-lg group">
                    <img src="https://wdtletsgo.wpengine.com/wp-content/uploads/2024/07/usa-1.jpg" alt=""
                        class="w-full h-64 object-cover transition-transform group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">
                        <h3 class="text-lg font-semibold text-white">USA Grand Explorer</h3>
                        <ul class="text-sm text-gray-200 space-y-1">
                            <li>Starts from - $29.00</li>
                            <li>7 Days - 5 Nights</li>
                            <li>Spring Season (Nov - Jan)</li>
                        </ul>
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="https://wdtletsgo.wpengine.com/blog/wdt_packages/luxury-usa-tour/"
                    class="relative rounded-lg overflow-hidden shadow-lg group">
                    <img src="https://wdtletsgo.wpengine.com/wp-content/uploads/2024/07/usa-3.jpg" alt=""
                        class="w-full h-64 object-cover transition-transform group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">
                        <h3 class="text-lg font-semibold text-white">Luxury USA Tour</h3>
                        <ul class="text-sm text-gray-200 space-y-1">
                            <li>Starts from - $19.00</li>
                            <li>2 Days - 1 Nights</li>
                            <li>Sightseeing (Feb- Apr)</li>
                        </ul>
                    </div>
                </a>

                <!-- Card 4 -->
                <a href="https://wdtletsgo.wpengine.com/blog/wdt_packages/turkey-spiritual-heritage/"
                    class="relative rounded-lg overflow-hidden shadow-lg group">
                    <img src="https://wdtletsgo.wpengine.com/wp-content/uploads/2024/07/turkey-3.jpg" alt=""
                        class="w-full h-64 object-cover transition-transform group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">
                        <h3 class="text-lg font-semibold text-white">Turkey Spiritual Heritage</h3>
                        <ul class="text-sm text-gray-200 space-y-1">
                            <li>Starts from - $19.00</li>
                            <li>2 Days - 2 Nights</li>
                            <li>All New Year (Dec - Mar)</li>
                        </ul>
                    </div>
                </a>

                <!-- Card 5 -->
                <a href="https://wdtletsgo.wpengine.com/blog/wdt_packages/exclusive-thailand-tour/"
                    class="relative rounded-lg overflow-hidden shadow-lg group">
                    <img src="https://wdtletsgo.wpengine.com/wp-content/uploads/2024/07/thailand-3.jpg" alt=""
                        class="w-full h-64 object-cover transition-transform group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">
                        <h3 class="text-lg font-semibold text-white">Exclusive Thailand Tour</h3>
                        <ul class="text-sm text-gray-200 space-y-1">
                            <li>Starts from - $9.00</li>
                            <li>3 Days - 2 Nights</li>
                            <li>Winter Tours (Dec - Feb)</li>
                        </ul>
                    </div>
                </a>

                <!-- Card 6 -->
                <a href="https://wdtletsgo.wpengine.com/blog/wdt_packages/turkey-beyond-beach-tour/"
                    class="relative rounded-lg overflow-hidden shadow-lg group">
                    <img src="https://wdtletsgo.wpengine.com/wp-content/uploads/2024/07/turkey-2.jpg" alt=""
                        class="w-full h-64 object-cover transition-transform group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">
                        <h3 class="text-lg font-semibold text-white">Turkey Beyond Beach Tour</h3>
                        <ul class="text-sm text-gray-200 space-y-1">
                            <li>Starts from - $32.00</li>
                            <li>3 Days - 2 Nights</li>
                            <li>All New Year (Sep- Dec)</li>
                        </ul>
                    </div>
                </a>

            </div>
        </div>
    </section>

    </div>
</x-guest-layout>
