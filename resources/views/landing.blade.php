<x-guest-layout>
    <x-slot name="nav">
        <section class="relative h-screen overflow-hidden">
            {{-- Background Gambar --}}
            <img src="{{ asset('storage/' . app(\App\Settings\WebsiteSettings::class)->header_image) ?? asset('defaults/no-image-header.png') }}"
                alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name }}"
                class="absolute inset-0 w-full h-full object-fill opacity-90 z-0">

            {{-- Overlay warna gradasi jika mau --}}
            <div class="absolute inset-0 bg-gradient-to-br from-teal-900/70 to-cyan-900/70 z-0"></div>

            {{-- Konten --}}
            <div class="relative z-10">
                {{-- TOP BAR --}}
                <div class="text-sm py-2 px-4 w-full bg-transparent text-white">
                    <div
                        class="container mx-auto flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                        <div class="space-x-4 text-center sm:text-left">
                            ✉️ {{ app(\App\Settings\WebsiteSettings::class)->contact_email ?? 'info@travelnesia.com' }}
                            📞 {{ app(\App\Settings\WebsiteSettings::class)->contact_phone ?? '0812-3456-7890' }}
                        </div>
                        <div class="space-x-3 text-center sm:text-right">
                            <div class="ml-4 inline-flex gap-2">
                                <a href="{{ route('lang.switch', 'id') }}"
                                    class="inline-flex items-center gap-1 {{ app()->getLocale() == 'id' ? 'font-bold underline' : '' }}">
                                    <svg class="w-4 h-4" viewBox="0 0 512 512">
                                        <circle cx="256" cy="256" r="256" fill="#fff" />
                                        <path fill="#e70000" d="M256,0
                                            A256,256 0 0,1 512,256
                                            L0,256
                                            A256,256 0 0,1 256,0z" />
                                    </svg>
                                    ID
                                </a>
                                |
                                <a href="{{ route('lang.switch', 'en') }}"
                                    class="inline-flex items-center gap-1 {{ app()->getLocale() == 'en' ? 'font-bold underline' : '' }}">
                                    <svg class="w-6 h-6" viewBox="0 0 60 30">
                                        <clipPath id="circle">
                                            <circle cx="30" cy="15" r="15" />
                                        </clipPath>
                                        <clipPath id="s">
                                            <path d="M30,15 h30 v15 h-30 z M0,0 h30 v15 h-30 z" />
                                        </clipPath>
                                        <g clip-path="url(#circle)">
                                            <path d="M0,0 v30 h60 v-30 z" fill="#012169" />
                                            <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6" />
                                            <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#s)" stroke="#c8102e"
                                                stroke-width="4" />
                                            <path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10" />
                                            <path d="M30,0 v30 M0,15 h60" stroke="#c8102e" stroke-width="6" />
                                        </g>
                                    </svg>
                                    EN
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- GARIS PEMISAH -->
                <div class="top-[50px] w-full border-t border-white opacity-10 z-40"></div>

                {{-- HEADER --}}
                <header class="w-full bg-transparent text-white transition-colors duration-300" x-data="{ open: false }">
                    <div class="container mx-auto flex justify-between items-center px-6 py-4">
                        {{-- Logo --}}
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 text-2xl font-bold text-white">
                            <img src="{{ asset('storage/' . app(\App\Settings\WebsiteSettings::class)->site_logo) ?? asset('defaults/no-image.png') }}"
                                alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}"
                                class="h-10 w-10 object-cover rounded-full shadow bg-white" />
                            <span>{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}</span>
                        </a>

                        {{-- Desktop Menu (≥ lg) --}}
                        <div class="hidden lg:flex space-x-8 items-center">
                            @if ($menu->isNotEmpty())
                                <ul class="flex space-x-4">
                                    @foreach ($menu as $item)
                                        <x-menu-item :item="$item" :depth="0" :isMobile="false" />
                                    @endforeach
                                </ul>
                            @endif

                            {{-- @guest
                                <a href="{{ route('login') }}"
                                    class="bg-lime-300 text-slate-900 px-5 py-2 rounded-lg shadow hover:bg-lime-200 transition">
                                    Masuk
                                </a>
                            @else
                            @endguest --}}

                            <x-booking-modal />

                        </div>

                        {{-- Hamburger Button (< lg) --}}
                        <button @click="open = !open"
                            class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-white hover:text-cyan-300 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-300">
                            <svg class="h-6 w-6" x-show="!open" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6" x-show="open" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Mobile Menu (< lg) --}}
                    <div x-show="open" x-transition @click.away="open = false"
                        class="lg:hidden px-6 pb-4 pt-2 space-y-2 bg-white text-gray-800 rounded-b-lg shadow">
                        @if ($menu->isNotEmpty())
                            <ul class="space-y-2">
                                @foreach ($menu as $item)
                                    <x-menu-item :item="$item" :depth="0" :isMobile="true" />
                                @endforeach
                            </ul>
                        @endif

                        {{-- @guest
                            <a href="{{ route('login') }}"
                                class="block py-2 px-3 rounded-lg hover:bg-cyan-600 hover:text-cyan-200 transition">
                                Masuk
                            </a> --}}

                        <a href="https://wa.me/{{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}?text={{ urlencode('halo saya ingin pesan paket tour') }}"
                            target="_blank"
                            class="block bg-lime-300 text-orange-950 px-5 py-2 rounded-lg mt-2 hover:bg-lime-200 text-center shadow transition">
                            {{ __('button.book_now') }}
                        </a>
                        {{-- @else
                            <a href="{{ route('profile.edit') }}"
                                class="block bg-cyan-300 text-orange-950 px-5 py-2 rounded-lg mt-2 hover:bg-cyan-600 text-center shadow transition">
                                My Account
                            </a>
                        @endguest --}}
                    </div>
                </header>

                {{-- HERO --}}
                <div class="relative flex flex-col items-center justify-center min-h-screen text-center px-4">
                    <div class="z-10 px-4 w-full max-w-3xl -translate-y-10">
                        <h1
                            class="text-2xl sm:text-4xl md:text-6xl font-bold mb-2 sm:mb-4 bg-gradient-to-r from-white to-lime-300 bg-clip-text text-transparent">
                            {{ $headerTitle }}
                        </h1>
                        <p class="text-sm sm:text-lg md:text-xl mb-4 sm:mb-8 text-white">
                            {{ $headerSubTitle }}
                        </p>
                    </div>
                </div>

            </div>
        </section>
    </x-slot>

    <section class="bg-gray-100 py-8 px-8">
        <div class="relative w-full">
            <div class="swiper w-full">
                <div class="swiper-wrapper">
                    @foreach ($slides as $slider)
                        <div class="swiper-slide">
                            <div class="container max-w-screen-xl mx-auto px-4">
                                <div class="grid md:grid-cols-2 gap-x-96 items-center">
                                    <!-- Gambar -->
                                    <div class="overflow-hidden rounded-lg shadow-lg">
                                        <img src="{{ $slider->media?->first()?->url }}"
                                            alt="{{ $slider->name ?? '-' }}" class="w-full h-96 object-cover">
                                    </div>

                                    <!-- Tulisan -->
                                    <div class="space-y-4">
                                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
                                            {{ $slider->name ?? '-' }}
                                        </h2>
                                        <p class="text-gray-600 text-lg">
                                            {!! $slider->description ?? '-' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigasi -->
                <div class="swiper-pagination mt-4"></div>
                <div class="swiper-button-prev absolute -left-32"></div>
                <div class="swiper-button-next absolute -right-32"></div>
            </div>
        </div>
    </section>


    {{-- Paket Tour Section --}}
    <section class="bg-sky-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-sm font-semibold tracking-widest text-cyan-950 uppercase mb-2">
                {{ __('tours.title') }}
            </h2>
            <h2 class="text-5xl font-black mb-8 text-cyan-950 leading-tight tracking-tight">
                {{ __('tours.subtitle') }}
            </h2>

            @if ($categories->count())
                <div class="grid gap-6 md:grid-cols-4" id="paket">
                    @foreach ($categories->take(8) as $category)
                        <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg transform transition-all ease-in-out duration-300 hover:shadow-none hover:custom-rounded-br"
                            style="--tw-rounded-br: 60px;">

                            {{-- Gambar full --}}
                            <div class="overflow-hidden">
                                <img src="{{ imageOrDefault($category->media?->first()?->url, 'card') }}"
                                    alt="{{ $category->title }}"
                                    class="w-full h-96 object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110">
                            </div>

                            {{-- Overlay tulisan --}}
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 z-20">
                                <h3
                                    class="transition-transform duration-500 ease-in-out transform group-hover:-translate-y-8 text-lg font-bold text-white hover:text-lime-300">
                                    {{ $category->name }}
                                </h3>

                                <div
                                    class="text-lg font-semibold text-white transition-transform duration-700 ease-in-out transform group-hover:-translate-y-8">
                                    {!! $category->description !!}
                                </div>
                            </div>

                            {{-- Tombol Browse Trips muncul dari bawah --}}
                            <div
                                class="absolute bottom-4 left-0 right-0 flex justify-center opacity-0 group-hover:opacity-100 transform translate-y-6 group-hover:translate-y-0 transition-all duration-1000 ease-in-out z-30">
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="bg-transparent px-4 py-2 rounded text-white text-sm font-semibold shadow underline hover:underline-offset-1 transition">
                                    {{ __('button.trips') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tambahkan tombol di bawah --}}
                <div class="mt-10">
                    <a href="{{ route('categories.index') }}"
                        class="inline-block bg-teal-900 text-white px-6 py-3 rounded-lg rounded-br-3xl shadow hover:bg-lime-300 hover:text-slate-900 transition">
                        {{ __('button.destination') }}
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
                {{ __('WhyUs.title') }}
            </h2>
            <h2 class="text-5xl font-black mb-8 text-cyan-950 leading-tight tracking-tight">
                {{ __('WhyUs.subtitle') }}
            </h2>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                {{-- Fitur kiri --}}
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($features->take(4) as $feature)
                            <div
                                class="relative group text-white p-4 rounded overflow-hidden bg-teal-900 hover:bg-lime-500 rounded-br-lg hover:rounded-br-3xl hover:rounded-tl-3xl transition-all duration-500 ease-in-out min-h-64">

                                {{-- Background --}}
                                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30
                transition-all duration-500 ease-in-out scale-105 group-hover:scale-100"
                                    style="background-image: url('{{ imageOrDefault($feature->media?->first()?->url, 'card') }}');">
                                </div>

                                {{-- Content --}}
                                <div
                                    class="relative z-10 flex flex-col justify-center h-full transition-all duration-500 ease-in-out group-hover:-translate-y-1">

                                    {{-- ICON --}}
                                    <div
                                        class="text-3xl mb-4 transition-all duration-500 ease-in-out opacity-100 group-hover:opacity-50">
                                        <img class="w-24 h-24 object-cover rounded-full mx-auto mb-2 border-2 border-lime-300 shadow-lg"
                                            src="{{ imageOrDefault($feature->media?->first()?->url, 'card') }}"
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
                            @foreach ($slides->take(3) as $slide)
                                <div class="swiper-slide relative">
                                    <img src="{{ imageOrDefault($slide->media?->first()?->url, 'card') }}"
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
            <h2 class="text-3xl font-bold text-center text-teal-900 mb-10">
                {{ __('PopularTrips.title') }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card Popular Tour -->
                @foreach ($popularTours->take(6) as $item)
                    <a href="{{ route('tours.show', $item->slug) }}"
                        class="relative rounded-lg overflow-hidden shadow-lg group">
                        <img src="{{ imageOrDefault($item->media?->first()?->url, 'card') }}"
                            alt="{{ $item->titlex }}"
                            class="w-full h-64 object-cover transition-transform group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">

                            <!-- Info -->
                            <div class="transition-all duration-300 group-hover:-translate-y-6">
                                <h3 class="text-lg font-semibold text-white transition-transform duration-700 ease-in-out transform group-hover:-translate-y-4">{{ $item->title }}</h3>
                                <h3 class="text-xs text-white transition-transform duration-1000 ease-in-out transform group-hover:-translate-y-4">{!! Str::limit($item->content, 50) !!}</h3>
                            </div>

                            <!-- Tombol muncul saat hover -->
                            <span
                                class="opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 inline-block mt-1">
                                <button
                                    class="px-3 py-1 text-sm bg-teal-700 text-white rounded hover:bg-teal-300 hover:text-teal-900 transition-colors">
                                    {{ __('button.read') }} →
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
                    <p class="text-sm uppercase tracking-widest text-gray-500 mb-2">{{ __('blogs.title') }}</p>
                    <h2 class="text-4xl font-bold text-gray-900">{{ __('blogs.subtitle') }}</h2>
                </div>
                <div class="max-w-xl text-gray-600 mt-4 md:mt-0">
                    {{ __('blogs.caption') }}
                    <br>
                    <a href="#" class="text-blue-700 underline font-medium">{{ __('button.view_all') }}</a>
                </div>
            </div>

            <!-- Cards -->
            <div class="grid gap-6 md:grid-cols-3">
                <!-- Card -->
                @foreach ($posts->take(3) as $post)
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
                            <a href="{{ route('blog.show', $post->slug) }}"
                                class="text-slate-900 font-medium text-md underline">Read More</a>
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
                <h2 class="text-4xl font-bold text-gray-900 mb-4 animate-fade-in-down">{{ __('contactUs.title') }}
                </h2>
                <p class="text-gray-600 animate-fade-in-up">
                    {{ __('contactUs.subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 text-lg">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4 animate-slide-in-left">
                        <div class="text-lime-500 text-3xl">📍</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ __('contactUs.office') }}</h4>
                            <p class="text-gray-600">
                                {{ app(\App\Settings\WebsiteSettings::class)->contact_address }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 animate-slide-in-right delay-200">
                        <div class="text-lime-500 text-3xl">🌐</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ __('contactUs.follow') }}</h4>
                            <div class="flex space-x-4 mt-2">
                                <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_facebook }}"
                                    class="text-gray-500 hover:text-lime-500 transition" aria-label="Facebook">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current"
                                        viewBox="0 0 320 512">
                                        <path
                                            d="M279.14 288l14.22-92.66h-88.91V134.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.36 44.38-121.36 124.72V195.3H22.89V288h81.11v224h100.2V288z" />
                                    </svg>
                                </a>
                                <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_instagram }}"
                                    class="text-gray-500 hover:text-lime-500 transition" aria-label="Instagram">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current"
                                        viewBox="0 0 448 512">
                                        <path
                                            d="M224.1 141c-63.6 0-115 51.4-115 115 0 63.6 51.4 115 115 115s115-51.4 115-115-51.4-115-115-115zm0 190c-41.6 0-75-33.4-75-75s33.4-75 75-75 75 33.4 75 75-33.4 75-75 75zm146.4-194.1c0 14.9-12.1 27-27 27-14.9 0-27-12.1-27-27s12.1-27 27-27 27 12.1 27 27zm76.1 27.2c-1.7-35.7-9.9-67.3-36.2-93.6C380.7 16.6 349.1 8.4 313.4 6.7 277.5 5 240.5 0 224 0c-16.5 0-53.5 5-89.4 6.7-35.7 1.7-67.3 9.9-93.6 36.2C16.6 99.3 8.4 130.9 6.7 166.6 5 202.5 0 239.5 0 256s5 53.5 6.7 89.4c1.7 35.7 9.9 67.3 36.2 93.6 26.3 26.3 57.9 34.5 93.6 36.2 35.9 1.7 72.9 6.7 89.4 6.7s53.5-5 89.4-6.7c35.7-1.7 67.3-9.9 93.6-36.2 26.3-26.3 34.5-57.9 36.2-93.6 1.7-35.9 6.7-72.9 6.7-89.4s-5-53.5-6.7-89.4zm-48.4 215c-7.8 19.5-22.8 34.5-42.3 42.3-29.2 11.7-98.4 9-130.8 9s-101.6 2.6-130.8-9c-19.5-7.8-34.5-22.8-42.3-42.3-11.7-29.2-9-98.4-9-130.8s-2.6-101.6 9-130.8c7.8-19.5 22.8-34.5 42.3-42.3 29.2-11.7 98.4-9 130.8-9s101.6-2.6 130.8 9c19.5 7.8 34.5 22.8 42.3 42.3 11.7 29.2 9 98.4 9 130.8s2.6 101.6-9 130.8z" />
                                    </svg>
                                </a>
                                <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_x }}"
                                    class="text-gray-500 hover:text-lime-500 transition" aria-label="Twitter">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M459.4 151.7c.3 2.8.3 5.7.3 8.6 0 87.4-66.5 188.2-188.2 188.2-37.3 0-72-11-101.2-29.8 5.3.6 10.4.8 15.7.8 31 0 59.6-10.6 82.3-28.4-29-.6-53.5-19.7-61.9-46 4 .6 8.1.8 12.1.8 5.9 0 11.8-.8 17.2-2.2-30.3-6.1-53.1-32.8-53.1-64.9v-.8c8.9 4.9 19 7.9 29.7 8.3-17.6-11.8-29.3-31.8-29.3-54.6 0-12.1 3.3-23.4 9-33.2 32.6 40.1 81.4 66.5 136.2 69.2-1.1-4.9-1.6-10.1-1.6-15.4 0-37.3 30.3-67.6 67.6-67.6 19.4 0 36.8 8.1 49.1 21.1 15.4-2.8 29.7-8.6 42.5-16.5-5.1 15.7-15.7 28.9-29.7 37.3 13.6-1.4 26.8-5.2 39-10.4-9 13.3-20.4 25.2-33.4 34.6z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start space-x-4 animate-slide-in-right">
                        <div class="text-lime-500 text-3xl">📞</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ __('contactUs.phone') }}</h4>
                            <p class="text-gray-600">{{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 animate-slide-in-right delay-100">
                        <div class="text-lime-500 text-3xl">✉️</div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Email</h4>
                            <p class="text-gray-600">{{ app(\App\Settings\WebsiteSettings::class)->contact_email }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Google Maps -->
            <div class="w-full h-96 mt-10 rounded-lg overflow-hidden shadow-lg animate-fade-in-up">
                {!! app(\App\Settings\WebsiteSettings::class)->maps !!}
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
