@section('title')
    <x-title :title="$seoMeta->meta_title . ' | '" />
@endsection

@section('seoMeta')
    <x-seo-meta :meta="$seoMeta" />
@endsection

<x-guest-layout>
    <x-slot name="nav">
        <x-header title="{{ $tour->title }}"
            breadcrumb="{{ __('destination.breadcrumb') }} > {{ $tour->category->name }}"
            image="{{ imageOrDefault($tour->media?->first()?->url, 'header') }}" alt="{{ $tour->name }}" />
    </x-slot>
    <div class="max-w-7xl mx-auto px-4">
        <section class="py-8">
            {{-- Title + Price --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">
                        {{ $tour->title }}
                    </h1>
                    <p class="text-gray-600 mt-2 max-w-4xl text-justify">
                        {!! $tour->summary !!}
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <p class="text-gray-800 font-semibold rounded border border-gray-200 px-3 py-2 text-justify"
                        style="border-radius: 0.25rem;">
                        {{ __('tours.packet') }}
                        @if (!empty($tour->packet) && is_array($tour->packet))
                            @foreach ($tour->packet as $item)
                                @php
                                    $value = is_array($item) ? $item['value'] ?? '' : $item;

                                    // cari posisi koma terakhir
                                    $delimiterPos = strrpos($value, ',');

                                    if ($delimiterPos !== false) {
                                        $first = trim(substr($value, 0, $delimiterPos)); // dari awal sampai sebelum koma
                                        $secondRaw = trim(substr($value, $delimiterPos + 1)); // setelah koma
                                    } else {
                                        $first = $value;
                                        $secondRaw = '';
                                    }

                                    $secondClean = (int) str_replace(['.', ','], '', $secondRaw);
                                @endphp

                                <span class="text-sm block">
                                    {{ $first . ', ' . $tour->formatCurrency($secondClean) }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-sm block text-gray-500">Tidak ada paket.</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Blue Info Box --}}
            <div
                class="bg-blue-100 rounded-lg mt-6 p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="text-gray-800 text-sm font-medium">
                    {{ __('tours.caption') }}: {{ $tour->duration }}
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex gap-2">
                        <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_facebook }}" target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-full border text-gray-800 hover:bg-teal-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"
                                viewBox="0 0 24 24">
                                <path
                                    d="M22,12A10,10,0,1,0,10.93,21.94V14.89H8v-2.9h2.93V9.35c0-2.89,1.72-4.49,4.35-4.49a17.58,17.58,0,0,1,2.57.22v2.83H16.86c-1.46,0-1.92.91-1.92,1.85v2.22h3.27l-.52,2.9H14.94v7.05A10,10,0,0,0,22,12Z" />
                            </svg>
                        </a>
                        <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_x }}" target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-full border text-gray-800 hover:bg-teal-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 448 512">
                                <path d="M448,209.9v95.1c-28.6,0-56.6-5.6-82.6-16.3v86.6c0,75.1-60.9,136-136,136S93.3,450.4,93.3,375.3
        s60.9-136,136-136c7.6,0,15,.6,22.2,1.8v91.6c-7.2-2.4-14.8-3.6-22.2-3.6c-37.4,0-67.7,30.3-67.7,67.7s30.3,67.7,67.7,67.7
        s67.7-30.3,67.7-67.7V0h82.6c0,62.5,50.7,113.2,113.2,113.2V209.9z" />
                            </svg>
                        </a>
                        <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_instagram }}" target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-full border text-gray-800 hover:bg-teal-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.515 2.567 5.782 2.295 7.148 2.233 8.414 2.175 8.794 2.163 12 2.163zm0-2.163C8.736 0 8.332.012 7.052.07 5.77.128 4.672.388 3.678 1.382 2.684 2.376 2.424 3.474 2.366 4.756 2.308 6.036 2.296 6.44 2.296 12s.012 5.964.07 7.244c.058 1.282.318 2.38 1.312 3.374.994.994 2.092 1.254 3.374 1.312 1.28.058 1.684.07 7.244.07s5.964-.012 7.244-.07c1.282-.058 2.38-.318 3.374-1.312.994-.994 1.254-2.092 1.312-3.374.058-1.28.07-1.684.07-7.244s-.012-5.964-.07-7.244c-.058-1.282-.318-2.38-1.312-3.374C21.38.388 20.282.128 19 .07 17.72.012 17.316 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <section class="py-8 max-w-7xl mx-auto px-4">
        <a href="#" target="_blank" class="block group">
            <img src="{{ imageOrDefault($tour->media?->first()?->url, 'card') }}" alt="{{ $tour->title }} image"
                class="rounded-lg w-full h-96 object-cover group-hover:bg-lime-300 group-hover:scale-105 transition-all duration-500 ease-in-out" />
        </a>
    </section>

    <section class="py-4 max-w-7xl mx-auto px-4">
        <div class="flex justify-center items-center mb-6">
            <x-booking-modal buttonClass="w-32 sm:w-32"
                colorClass="bg-orange-400 text-slate-900 font-bold hover:bg-orange-200" />
        </div>

        <div x-data="{ tab: 'overview' }">
            {{-- Tabs --}}
            <div class="flex justify-center gap-2 mb-4 flex-wrap">
                <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                    class="px-4 py-2 rounded shadow flex items-center gap-2">
                    {{ __('tours.overview') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 17L17 7M7 7h10v10" />
                    </svg>
                </button>
                <button @click="tab = 'info'" :class="tab === 'info' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                    class="px-4 py-2 rounded shadow flex items-center gap-2">
                    {{ __('tours.notes') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 17L17 7M7 7h10v10" />
                    </svg>
                </button>
                <button @click="tab = 'terms'" :class="tab === 'terms' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                    class="px-4 py-2 rounded shadow flex items-center gap-2">
                    {{ __('tours.itinerary') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 17L17 7M7 7h10v10" />
                    </svg>
                </button>
            </div>

            {{-- Konten tabs --}}
            <div class="mt-6">
                {{-- Overview --}}
                <div x-show="tab === 'overview'" x-cloak x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4">
                    <div class="p-4">
                        <div class="bg-white rounded-lg border p-4 md:p-6">
                            <div class="prose prose-sm max-w-none text-gray-800">
                                {!! $tour->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div x-show="tab === 'info'" x-cloak x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                    <div class="p-4">
                        <div class="bg-white rounded-lg border p-4 md:p-6 gap-6">
                            <div class="prose prose-xs max-w-none text-gray-800">
                                {!! $tour->notes !!}
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Terms --}}
                <div x-show="tab === 'terms'" x-cloak x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 -translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4">
                    <div class="p-4">
                        <div class="bg-white rounded-lg border p-4 md:p-6 gap-6">
                            <div class="prose prose-xs max-w-none text-gray-800">
                                {!! $tour->itinerary !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-6">
            {{-- KIRI: Includes & Excludes --}}
            <div class="flex-1 bg-white rounded-lg border p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Includes --}}
                    <div>
                        <h3 class="text-xl pace-y-2 text-gray-700 font-bold mb-4">{{ __('tours.include') }}:</h3>
                        <div class="prose prose-xs max-w-none text-gray-800">
                            {!! $tour->include !!}
                        </div>
                    </div>

                    {{-- Excludes --}}
                    <div class="md:border-l md:pl-6">
                        <h3 class="text-xl space-y-2 text-gray-700 font-bold mb-4">{{ __('tours.exclude') }}:</h3>
                        <div class="prose prose-xs max-w-none text-gray-800">
                            {!! $tour->exclude !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- KANAN: Book A Trip --}}
            <div
                class="w-full md:w-2/4 bg-teal-100/30 rounded-lg p-6 flex-shrink-0 flex flex-wrap md:flex-nowrap gap-4 items-start">

                {{-- Tombol Book Now (Mobile Only) --}}
                <div class="block md:hidden w-full">
                    <x-booking-modal :selected-program-id="$tour->id" />
                </div>

                {{-- Icon Sosial Media --}}
                <div class="flex flex-col md:flex-row md:items-center gap-2 w-full">
                    {{-- Tombol Book Now (Desktop Only) --}}
                    <div class="hidden md:block">
                        <x-booking-modal :selected-program-id="$tour->id" />
                    </div>

                    {{-- Share Section --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-gray-700 font-semibold">{{ __('Share with:') }}</span>

                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                            target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-700 text-white transition">
                            {{-- SVG --}}
                        </a>

                        {{-- X (Twitter) --}}
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($tour->title) }}"
                            target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-500 hover:bg-sky-600 text-white transition">
                            {{-- SVG --}}
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/?text={{ urlencode($tour->title . ' ' . request()->fullUrl()) }}"
                            target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-green-500 hover:bg-green-600 text-white transition">
                            {{-- SVG --}}
                        </a>

                        {{-- Telegram --}}
                        <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($tour->title) }}"
                            target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-400 hover:bg-blue-500 text-white transition">
                            {{-- SVG --}}
                        </a>
                    </div>
                </div>
            </div>

    </section>

    </div>

</x-guest-layout>
