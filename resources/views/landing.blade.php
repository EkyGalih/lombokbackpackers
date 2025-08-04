<x-guest-layout>
    <x-slot name="nav">
        <div x-data="{ scrolled: false, open: false }" @scroll.window="scrolled = window.scrollY > 50">

            {{-- ✅ TOP BAR (ikut berubah saat scroll) --}}
            <div :class="scrolled ? 'bg-white text-gray-900 border-b border-gray-200' : 'bg-transparent text-white'"
                class="text-sm py-2 px-4 fixed top-0 left-0 right-0 z-50 transition-colors duration-300">
                <div class="container mx-auto flex justify-between items-start">
                    <div class="flex flex-col sm:items-start items-start text-left sm:text-left">
                        <div>✉️ {{ app(\App\Settings\WebsiteSettings::class)->contact_email ?? 'info@travelnesia.com' }}
                        </div>
                        <div>📞 {{ app(\App\Settings\WebsiteSettings::class)->contact_phone ?? '0812-3456-7890' }}</div>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('lang.switch', 'id') }}"
                            :class="scrolled ?
                                'bg-gradient-to-br from-red-600 to-white bg-clip-text text-transparent font-bold underline' :
                                'bg-gradient-to-b from-red-600 to-white bg-clip-text text-transparent font-bold underline'"
                            class="transition-colors duration-300 {{ app()->getLocale() == 'id' ? 'font-bold underline' : '' }}">ID</a>
                        |
                        <a href="{{ route('lang.switch', 'en') }}"
                            :class="scrolled ?
                                'bg-gradient-to-br from-blue-900 via-white to-red-600 bg-clip-text text-transparent font-bold underline' :
                                'bg-gradient-to-br from-blue-900 via-white to-red-600 bg-clip-text text-transparent font-bold underline'"
                            class="transition-colors duration-300 {{ app()->getLocale() == 'en' ? 'font-bold underline' : '' }}">EN</a>
                    </div>
                </div>
            </div>

            {{-- ✅ NAVBAR --}}
            <header :class="scrolled ? 'bg-white text-gray-900 shadow' : 'bg-transparent text-white'"
                class="fixed top-[44px] left-0 right-0 z-40 transition-colors duration-300">
                <div class="container mx-auto flex justify-between items-center px-6 py-4">
                    {{-- Logo --}}
                    <a href="/" class="flex items-center space-x-3 text-1xl font-bold">
                        <img src="{{ asset('storage/' . app(\App\Settings\WebsiteSettings::class)->site_logo) }}"
                            class="h-10 w-10 object-cover rounded-full bg-white" />
                        <span>{{ app(\App\Settings\WebsiteSettings::class)->site_name }}</span>
                    </a>

                    {{-- Menu Desktop --}}
                    <div class="hidden lg:flex space-x-8 items-center">
                        @if ($menu->isNotEmpty())
                            <ul class="flex space-x-4">
                                @foreach ($menu as $item)
                                    <x-menu-item :item="$item" :depth="0" :isMobile="false" />
                                @endforeach
                            </ul>
                        @endif
                        <x-booking-modal buttonClass="w-32" />
                    </div>

                    {{-- Hamburger Mobile --}}
                    <button @click="open = !open" :class="scrolled ? 'text-gray-900' : 'text-white'"
                        class="lg:hidden p-2 focus:outline-none transition-colors duration-300">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Mobile Menu --}}
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

                    {{-- @else
                            <a href="{{ route('profile.edit') }}"
                                class="block bg-cyan-300 text-orange-950 px-5 py-2 rounded-lg mt-2 hover:bg-cyan-600 text-center shadow transition">
                                My Account
                            </a>
                            @endguest --}}
                    <x-booking-modal buttonClass="w-full sm:w-32" />
                </div>
            </header>

        </div>

        {{-- SECTION HERO --}}
        <section class="pt-[160px] relative aspect-[3/4] md:aspect-[16/9] overflow-hidden">
            <img src="{{ asset('storage/' . app(\App\Settings\WebsiteSettings::class)->header_image) ?? asset('defaults/no-image-header.png') }}"
                alt="Header" class="absolute inset-0 w-full h-full object-cover opacity-90 z-0" />
            <div class="absolute inset-0 bg-gradient-to-br from-teal-900/70 to-cyan-900/70 z-0"></div>

            <div class="relative px-4 min-h-screen md:flex md:items-center md:justify-center text-center">
                <div
                    class="w-full max-w-3xl mx-auto px-4
               absolute top-10 sm:top-20 mt-36 md:mt-40 md:static">
                    <h1
                        class="text-2xl sm:text-4xl md:text-6xl font-bold mb-2 sm:mb-4 bg-gradient-to-r from-white to-lime-300 bg-clip-text text-transparent">
                        {{ $headerTitle }}
                    </h1>
                    <p class="text-sm sm:text-lg md:text-xl mb-4 sm:mb-8 text-white">
                        {{ $headerSubTitle }}
                    </p>
                    <x-booking-modal buttonClass="w-32 sm:w-32" />
                </div>
            </div>
        </section>
    </x-slot>

    <section class="bg-gray-100 py-8 md:py-12 lg:py-16 px-4 md:px-6 lg:px-20">
        <div class="container mx-auto text-center">
            <h2
                class="text-3xl md:text-4xl lg:text-5xl font-black mb-6 md:mb-8 text-cyan-950 leading-tight tracking-tight uppercase">
                {{ $welcome->title }}
            </h2>
            <h2 class="text-xs md:text-sm font-semibold tracking-widest text-cyan-950">
                {!! $welcome->description !!}
            </h2>
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
                                    class="transition-transform duration-500 ease-in-out transform
       -translate-y-8
       md:translate-y-0 md:group-hover:-translate-y-8
       text-lg font-bold text-white hover:text-lime-300
       bg-black/40 px-2 py-1 rounded mb-4 md:mb-0">
                                    {{ $category->name }}
                                </h3>

                            </div>

                            {{-- Tombol Browse Trips --}}
                            <div
                                class="absolute bottom-4 left-0 right-0 flex justify-center
    opacity-100 translate-y-0
    md:opacity-0 md:translate-y-6 md:group-hover:opacity-100 md:group-hover:translate-y-0
    transition-all duration-1000 ease-in-out z-30">

                                {{-- Mode desktop --}}
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="hidden md:inline-block bg-transparent px-4 py-2 rounded text-white text-sm font-semibold shadow underline hover:underline-offset-1 transition">
                                    {{ __('button.trips') }}
                                </a>

                                {{-- Mode mobile --}}
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="inline-block md:hidden bg-lime-500 px-4 py-2 rounded-br-3xl rounded-tr-md text-white text-sm font-bold shadow-md hover:bg-lime-600 transition">
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
            {{-- <h2 class="text-sm font-semibold tracking-widest text-cyan-950 uppercase mb-2">
                {{ __('WhyUs.title') }}
            </h2> --}}
            <h2 class="text-5xl font-black mb-8 text-cyan-950 leading-tight tracking-tight">
                {{ __('WhyUs.title') }}
            </h2>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 text-left">
                {{-- Fitur kiri --}}
                <div class="space-y-2">
                    <ul class="space-y-2">
                        @foreach ($services as $feature)
                            <li class="flex items-start gap-2">
                                {{-- Bullet --}}
                                <span class="w-2 h-2 mt-1 rounded-full bg-teal-600 shrink-0"></span>

                                {{-- Title + Description --}}
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800">
                                        {{ $feature['title'] }}
                                    </h3>

                                    <p class="text-sm text-gray-600 text-wrap justify-between">
                                        {!! $feature['description'] !!}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Slider kanan --}}
                <div>
                    <div class="swiper swiper-whyus">
                        <div class="swiper-wrapper">
                            @foreach ($slides->take(3) as $slide)
                                <div class="swiper-slide relative">
                                    <img src="{{ imageOrDefault($slide->media?->first()?->url, 'card') }}"
                                        class="w-full object-cover rounded-lg h-96">

                                    <div
                                        class="absolute bottom-4 left-4 right-4 md:right-auto text-white bg-black/50 p-3 md:p-4 rounded space-y-2 max-w-xs md:max-w-full">
                                        <h2 class="text-sm md:text-2xl font-bold">{{ $slide->title }}</h2>
                                        <p class="text-[10px] md:text-sm text-wrap justify-between">
                                            {!! Str::limit($slide->description, 300, '...') !!}</p>
                                        </p>
                                        <a href="{{ route('categories.show', $slide->slug) }}"
                                            class="inline-block px-3 py-1 bg-lime-600 hover:bg-lime-700 text-white text-xs font-medium rounded-br-3xl rounded-tr-md transition">
                                            {{ __('button.read') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination swiper-pagination-whyus absolute top-2 right-2 z-10"></div>
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

            <div class="hidden md:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card Popular Tour -->
                @foreach ($popularTours->take(6) as $item)
                    <x-popular-card :item="$item" />
                @endforeach
            </div>

            <div class="md:hidden">
                <div class="swiper swiper-popular">
                    <div class="swiper-wrapper">
                        @foreach ($popularTours->take(6) as $item)
                            <div class="swiper-slide">
                                <x-popular-card :item="$item" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination swiper-pagination-popular"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- shortcut --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-teal-900 mb-10">
                {{ __('message.shortcut.title') }}
            </h2>

            {{-- Desktop Grid --}}
            <div class="hidden md:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($shortcut as $categoryName => $tours)
                    <div>
                        <h2 class="font-bold text-slate-800 mb-2">{{ $categoryName }}</h2>
                        <ul class="list-disc pl-4 space-y-1 text-slate-700">
                            @foreach ($tours->take(5) as $item)
                                <x-list-shortcut :item="$item" />
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            {{-- Mobile List --}}
            <div class="block md:hidden">
                @foreach ($shortcut as $categoryName => $tours)
                    <h2 class="font-bold text-slate-800 mt-4 mb-2">{{ $categoryName }}</h2>
                    <ul class="list-disc pl-4 space-y-1 text-slate-700">
                        @foreach ($tours->take(5) as $item)
                            <x-list-shortcut :item="$item" />
                        @endforeach
                    </ul>
                @endforeach
            </div>

        </div>
    </section>

    {{-- post --}}
    <section class="bg-sky-100 py-16">
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
                    <a href="{{ route('blog.index') }}"
                        class="inline-block px-3 py-1 bg-teal-600 hover:bg-teal-700 text-white text-md font-medium rounded-br-3xl rounded-tr-md transition">{{ __('button.view_all') }}</a>
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
                                class="text-teal-700 font-medium text-md underline">{{ __('button.read') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- contact us --}}
    <section class="relative bg-gradient-to-r from-white via-teal-50 to-white py-16 overflow-hidden">
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
                                {!! app(\App\Settings\WebsiteSettings::class)->contact_address !!}
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
                                    class="text-gray-500 hover:text-lime-500 transition" aria-label="TikTok">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current"
                                        viewBox="0 0 448 512">
                                        <path d="M448,209.9v95.1c-28.6,0-56.6-5.6-82.6-16.3v86.6c0,75.1-60.9,136-136,136S93.3,450.4,93.3,375.3
        s60.9-136,136-136c7.6,0,15,.6,22.2,1.8v91.6c-7.2-2.4-14.8-3.6-22.2-3.6c-37.4,0-67.7,30.3-67.7,67.7s30.3,67.7,67.7,67.7
        s67.7-30.3,67.7-67.7V0h82.6c0,62.5,50.7,113.2,113.2,113.2V209.9z" />
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
