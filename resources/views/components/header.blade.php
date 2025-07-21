<div class="text-sm py-2 px-4 w-full bg-white text-teal-900">
    <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
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
                            <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#s)" stroke="#c8102e" stroke-width="4" />
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
<div class="top-[50px] w-full border-t border-teal-900 opacity-10 z-40"></div>

{{-- HEADER --}}
<header class="w-full bg-transparent text-slate-900 transition-colors duration-300" x-data="{ open: false }">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center space-x-3 text-2xl font-bold text-slate-800">
            <img src="{{ asset('storage/'.app(\App\Settings\WebsiteSettings::class)->site_logo) }}"
                alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}"
                class="h-10 w-10 object-cover rounded-full shadow bg-white" />
            <span>{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}</span>
        </a>

        {{-- Desktop Menu (≥ lg) --}}
        <div class="hidden lg:flex space-x-8 items-center">
            @php
                $MainMenu = \Biostate\FilamentMenuBuilder\Models\Menu::first();
                $menu =
                    $MainMenu
                        ?->items()
                        ->whereNull('parent_id')
                        ->with('children.children.children')
                        ->defaultOrder()
                        ->get() ?? collect();
            @endphp

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
            @else --}}
            <a href="https://wa.me/{{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}?text={{ urlencode('halo saya ingin pesan paket tour') }}"
                target="_blank"
                class="bg-lime-300 text-slate-900 px-5 py-2 rounded-lg shadow hover:bg-lime-200 transition">
                {{ __('button.book_now') }}
            </a>
            {{-- @endguest --}}
        </div>

        {{-- Hamburger Button (< lg) --}}
        <button @click="open = !open"
            class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-cyan-800 hover:text-cyan-300 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-300">
            <svg class="h-6 w-6" x-show="!open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg class="h-6 w-6" x-show="open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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

        <a href="https://wa.me/{{ app(\App\Settings\WebsiteSettings::class)->contact_phone }}?text={{ urlencode(__('message.message')) }}"
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

<section class="relative h-44 overflow-hidden">
    {{-- Background Gambar --}}
    <img src="{{ $image ?? asset('storage/'.app(\App\Settings\WebsiteSettings::class)->header_image) }}"
        alt="{{ $alt ?? app(\App\Settings\WebsiteSettings::class)->site_name }}"
        class="absolute inset-0 w-full h-full object-cover opacity-50 filter blur-sm z-0">

    {{-- Overlay warna gradasi --}}
    <div class="absolute inset-0 bg-gradient-to-br from-teal-950/60 to-teal-950/80 z-0"></div>

    {{-- Konten --}}
    <div class="relative z-10 h-full flex items-start justify-start">
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)" x-show="show"
            x-transition:enter="transform opacity-0 -translate-x-full"
            x-transition:enter-end="transform opacity-100 translate-x-0" x-transition:enter.duration.1000ms x-cloak
            class="p-8 md:p-16">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-2 text-white drop-shadow-lg">
                {{ $title }}
            </h1>
            @if ($breadcrumb != null)
            <p class="text-xs md:text-sm mb-4 font-semibold text-white drop-shadow">
                Home > {{ $breadcrumb }}
            </p>
            @endif
        </div>
    </div>
</section>
