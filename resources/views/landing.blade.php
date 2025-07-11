<x-guest-layout>
    <x-slot name="nav">
        <section class="relative h-screen overflow-hidden">
            {{-- Background Gambar --}}
            <img src="{{ app(\App\Settings\WebsiteSettings::class)->header_image }}"
                alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name }}"
                class="absolute inset-0 w-full h-full object-cover opacity-90 z-0">

            {{-- Overlay warna gradasi jika mau --}}
            <div class="absolute inset-0 bg-gradient-to-br from-teal-900/70 to-cyan-900/70 z-0"></div>

            {{-- Konten --}}
            <div class="relative z-10">
                {{-- TOP BAR --}}
                <div class="text-sm py-2 px-4 w-full bg-transparent text-white">
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
                <div class="top-[50px] w-full border-t border-white opacity-10 z-40"></div>

                {{-- HEADER --}}
                <header class="w-full bg-transparent text-white transition-colors duration-300">
                    <div class="container mx-auto flex justify-between items-center px-6 py-4">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 text-2xl font-bold text-white">
                            <img src="{{ app(\App\Settings\WebsiteSettings::class)->site_logo ?? asset('defaults/logo.png') }}"
                                alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name }}"
                                class="h-10 w-10 object-contain rounded-full bg-white/80 p-1 shadow" />
                            <span>{{ app(\App\Settings\WebsiteSettings::class)->site_name }}</span>
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

                {{-- HERO --}}
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
                }"
                    class="relative flex flex-col items-center justify-center min-h-screen text-center px-4">

                    {{-- MODAL GAMBAR --}}
                    <div x-show="showModal" x-transition.opacity
                        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">
                        <div class="relative bg-transparent rounded-lg shadow-lg h-full w-full overflow-hidden">

                            <!-- Tombol close di luar gambar -->
                            <button @click="showModal = false"
                                class="absolute top-4 right-4 text-white text-3xl z-20">&times;</button>

                            <!-- Gambar + panah -->
                            <div class="relative flex items-center justify-center h-full w-full">
                                <img :src="images[activeTab][modalIndex]" alt=""
                                    class="w-96 h-96 object-cover rounded-lg">

                                <!-- Tombol prev -->
                                <button
                                    @click="modalIndex = (modalIndex - 1 + images[activeTab].length) % images[activeTab].length"
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

                    <div class="text-center z-10 px-4 max-w-3xl">
                        <h1
                            class="text-4xl md:text-6xl font-bold mb-4 bg-gradient-to-r from-white to-lime-300 bg-clip-text text-transparent">
                            {{ $headerTitle }}
                        </h1>
                        <p class="text-lg md:text-xl mb-8 text-white">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white z-20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <a href="#"
                            class="bg-lime-300 text-slate-900 font-semibold px-6 py-3 rounded-lg shadow rounded-br-3xl hover:bg-lime-200 transition">
                            Explore More
                        </a>
                    </div>
                    {{-- TABS --}}
                    <div class="z-30 flex flex-wrap justify-center mt-6 gap-4 px-4 mb-36">
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
                                class="font-semibold px-8 py-3 rounded-lg rounded-br-3xl w-72 text-center mt-12"
                                x-text="tab.label"></button>
                        </template>
                    </div>
                </div>

            </div>
        </section>
    </x-slot>

    {{-- services --}}
    <section class="bg-white py-20">
        <div class="container mx-auto flex flex-col md:flex-row items-center">
            <!-- Left: Image -->
            <div class="md:w-1/2 flex justify-center mb-8 md:mb-0">
                <img src="https://wdtletsgo.wpengine.com/wp-content/uploads/2025/03/Demo-1-Filler-Image.png"
                    alt="Traveler" class="max-w-xs md:max-w-sm">
            </div>

            <!-- Right: Content -->
            <div class="md:w-1/2 px-6">
                <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">Dapatkan Pengalaman yang disesuaikan</p>
                <h1 class="text-4xl font-bold leading-tight mb-6">
                    <span class="bg-lime-200 px-1">Paspor Anda Menuju <span class="bg-lime-200 px-1">Petualangan</span>
                        Yang Tak Terlupakan</span><br>
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    @foreach ($features as $feature)
                        <div>
                            <div class="text-2xl mb-4">
                                <div class="flex items-center justify-start">
                                    <img src="{{ $feature->media?->first()->url }}" alt="{{ $feature->title }}"
                                        class="w-12 h-12 rounded-full object-cover mr-3">
                                </div>
                            </div>
                            <h2 class="text-lg font-bold hover:text-lime-400 cursor-pointer mb-4">{{ $feature->title }}
                            </h2>
                            <p class="text-gray-600 text-sm">{{ $feature->description }}</p>
                        </div>
                    @endforeach
                </div>

                <a href="#offerings" class="inline-block bg-lime-200 text-gray-800 px-6 py-3 rounded font-semibold">
                    Discover Our Offerings
                </a>

                <div class="flex items-center mt-6">
                    <div class="flex -space-x-2">
                        <img src="{{ asset('images/client1.jpg') }}"
                            class="w-10 h-10 rounded-full border-2 border-white" alt="">
                        <img src="{{ asset('images/client2.jpg') }}"
                            class="w-10 h-10 rounded-full border-2 border-white" alt="">
                        <img src="{{ asset('images/client3.jpg') }}"
                            class="w-10 h-10 rounded-full border-2 border-white" alt="">
                    </div>
                    <div class="ml-4 text-sm">
                        <span class="text-lg font-bold">114K+</span> Happy Clients
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Paket Tour Section --}}
    <section class="bg-sky-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-sm font-semibold tracking-widest text-cyan-950 uppercase mb-2">
                Paket Tour Unggulan
            </h2>
            <h2 class="text-6xl font-black mb-8 text-cyan-950 leading-tight tracking-tight">
                Pilih Paket Perjalananmu
            </h2>

            @if ($categories->count())
                <div class="grid gap-6 md:grid-cols-4" id="paket">
                    @foreach ($categories as $category)
                        <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg transform transition-all ease-in-out duration-300 hover:shadow-none hover:custom-rounded-br"
                            style="--tw-rounded-br: 60px;">

                            {{-- Gambar full --}}
                            <div class="overflow-hidden">
                                <img src="{{ $category->media->first()->url ?? asset('defaults/tours/default1.jpg') }}"
                                    alt="{{ $category->title }}"
                                    class="w-full h-96 object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110">
                            </div>

                            {{-- Overlay tulisan --}}
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 z-20">
                                <div
                                    class="transition-transform duration-500 ease-in-out transform group-hover:-translate-y-8">
                                    <h3 class="text-lg font-bold text-white hover:text-lime-300 transition">
                                        {{ $category->name }}
                                    </h3>

                                    <p class="text-sm font-semibold text-white">
                                        {!! $category->description !!}
                                    </p>
                                </div>
                            </div>

                            {{-- Tombol Browse Trips muncul dari bawah --}}
                            <div
                                class="absolute bottom-4 left-0 right-0 flex justify-center opacity-0 group-hover:opacity-100 transform translate-y-6 group-hover:translate-y-0 transition-all duration-500 ease-in-out z-30">
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="bg-transparent px-4 py-2 rounded text-white text-sm font-semibold shadow underline hover:underline-offset-1 transition">
                                    Browse Trips
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tambahkan tombol di bawah --}}
                <div class="mt-10">
                    <a href="{{ route('categories.index') }}"
                        class="inline-block bg-teal-900 text-white px-6 py-3 rounded-lg rounded-br-3xl shadow hover:bg-lime-300 hover:text-slate-900 transition">
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
                                            src="{{ $feature->media?->first()->url }}"
                                            alt="{{ $feature['title'] }}">
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
                            @foreach ($slides as $slide)
                                <div class="swiper-slide relative">
                                    <img src="{{ $slide->media?->first()->url }}"
                                        class="w-full object-cover rounded-lg h-96">
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <h2 class="text-2xl font-bold">{{ $slide->title }}</h2>
                                        <p>{!! $slide->description !!}</p>
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

    {{-- wisata populer --}}
    <section class="py-12 bg-sky-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-teal-800 mb-10">
                Wisata Populer
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card Popular Tour -->
                @foreach ($popularTours as $item)
                    <a href="{{ route('tours.show', $item->slug) }}"
                        class="relative rounded-lg overflow-hidden shadow-lg group">
                        <img src="{{ $item->media?->first()?->url }}"
                            alt="{{ $item->titlex }}"
                            class="w-full h-64 object-cover transition-transform group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">

                            <!-- Info -->
                            <div class="transition-all duration-300 group-hover:-translate-y-6">
                                <h3 class="text-lg font-semibold text-white">{{ $item->title }}</h3>
                                <ul class="text-sm text-gray-200 space-y-1">
                                    <li>
                                        @if ($item->lowest_price)
                                            Rp {{ number_format($item->lowest_price, 0, ',', '.') }}
                                        @else
                                            Rp. 0
                                        @endif
                                    </li>
                                    <li>{{ $item->duration }}</li>
                                    <li>
                                        @foreach ($item->ratings as $rating)
                                            <div class="flex gap-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $rating['rating'])
                                                        <span class="text-yellow-400">★</span>
                                                    @else
                                                        <span class="text-gray-300">★</span>
                                                    @endif
                                                @endfor
                                            </div>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>

                            <!-- Tombol muncul saat hover -->
                            <span
                                class="opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 inline-block mt-1">
                                <button
                                    class="px-3 py-1 text-sm bg-teal-700 text-white rounded hover:bg-teal-300 hover:text-teal-900 transition-colors">
                                    Explore Trip →
                                </button>
                            </span>

                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- post --}}
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
                <div>
                    <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">News & Trends in Travel</p>
                    <h2 class="text-4xl font-bold text-gray-900">News, Tips & Destination Stories</h2>
                </div>
                <div class="max-w-xl text-gray-600 mt-4 md:mt-0">
                    Blandit conubia ullamcorper nullam dictum non. Tincidunt augue interdum velit euismod in
                    pellentesque. Molestie nunc non blandit massa enim.
                    <br>
                    <a href="#" class="text-blue-700 underline font-medium">View All Blogs</a>
                </div>
            </div>

            <!-- Cards -->
            <div class="grid gap-6 md:grid-cols-3">
                <!-- Card -->
                @foreach ($posts as $post)
                    <div class="relative rounded overflow-hidden shadow hover:shadow-lg transition group">
                        <img src="{{ $post->media?->first()?->url ?? asset('defaults/no-image.jpg') }}"
                            alt=""
                            class="w-full h-[500px] object-cover transform transition-transform duration-700 ease-in-out group-hover:scale-150">

                        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-md p-4 mx-4 mb-4 shadow-md">
                            <div class="flex items-center text-sm text-gray-500 space-x-4 mb-2">
                                <span>👤 {{ $post->author->name }}</span>
                                <span>{{ \Carbon\Carbon::parse($post->created_at)->locale(app()->getLocale())->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{!! $post->excerpt !!}</p>
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-slate-900 font-medium text-md underline">Read More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- contact us --}}
    <section class="relative bg-gradient-to-r from-teal-100 via-white to-teal-100 py-16 overflow-hidden">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4 animate-fade-in-down">Hubungi Kami</h2>
                <p class="text-gray-600 animate-fade-in-up">
                    Hubungi kami kapan saja. Berikut cara menghubungi tim kami.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 text-lg">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4 animate-slide-in-left">
                        <div class="text-lime-500 text-3xl">📍</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Our Office</h4>
                            <p class="text-gray-600">
                                Jl. Merdeka No.123, Jakarta Pusat, Indonesia
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 animate-slide-in-right delay-200">
                        <div class="text-lime-500 text-3xl">🌐</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Follow Us</h4>
                            <div class="flex space-x-4 mt-2">
                                <a href="#" class="text-gray-500 hover:text-lime-500 transition">Facebook</a>
                                <a href="#" class="text-gray-500 hover:text-lime-500 transition">Instagram</a>
                                <a href="#" class="text-gray-500 hover:text-lime-500 transition">Twitter</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start space-x-4 animate-slide-in-right">
                        <div class="text-lime-500 text-3xl">📞</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Phone</h4>
                            <p class="text-gray-600">+62 812 3456 7890</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 animate-slide-in-right delay-100">
                        <div class="text-lime-500 text-3xl">✉️</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Email</h4>
                            <p class="text-gray-600">hello@yourcompany.com</p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Google Maps -->
            <div class="w-full h-96 rounded-lg overflow-hidden shadow-lg animate-fade-in-up">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126914.50833836473!2d106.6894306!3d-6.2297282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1579f63c7fd%3A0xb29f4e22be74e6a1!2sJakarta%20Pusat!5e0!3m2!1sen!2sid!4v1720673000000!5m2!1sen!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Decorative shapes -->
        <div
            class="absolute -top-10 -left-10 w-40 h-40 bg-lime-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse">
        </div>
        <div
            class="absolute -bottom-10 -right-10 w-40 h-40 bg-lime-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse delay-200">
        </div>
    </section>


    </div>
</x-guest-layout>
