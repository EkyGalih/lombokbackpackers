@section('seoMeta')
    <x-seo-meta :meta="$seoMeta" />
@endsection

<x-guest-layout>
    <x-slot name="nav">
        <x-header title="{{ $tour->title }}" breadcrumb="Destination > {{ $tour->category->name }}"
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
                        Packet
                        @if (!empty($tour->packet))
                            @foreach ($tour->packet as $item)
                                <span class="text-sm block">{{ $item['value'] }}</span>
                            @endforeach
                        @endif
                    </p>
                </div>
            </div>

            {{-- Blue Info Box --}}
            <div
                class="bg-blue-100 rounded-lg mt-6 p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="text-gray-800 text-sm font-medium">
                    Duration: {{ $tour->duration }}
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"
                                viewBox="0 0 24 24">
                                <path
                                    d="M22.46 6c-.77.35-1.6.58-2.46.69A4.27 4.27 0 0021.86 4c-.83.49-1.75.84-2.72 1a4.26 4.26 0 00-7.26 3.89A12.07 12.07 0 013 5.12a4.26 4.26 0 001.32 5.7 4.23 4.23 0 01-1.93-.53v.05a4.27 4.27 0 003.42 4.18 4.3 4.3 0 01-1.92.07 4.27 4.27 0 003.99 2.97A8.57 8.57 0 012 19.54a12.06 12.06 0 006.55 1.92c7.87 0 12.18-6.52 12.18-12.18 0-.19 0-.37-.01-.56A8.72 8.72 0 0024 6.51a8.48 8.48 0 01-2.54.7A4.23 4.23 0 0022.46 6z" />
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
                        <a href="{{ app(\App\Settings\WebsiteSettings::class)->social_youtube }}" target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-full border text-gray-800 hover:bg-teal-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"
                                viewBox="0 0 24 24">
                                <path
                                    d="M23.5 6.5a3 3 0 00-2.11-2.11C19.42 4 12 4 12 4s-7.42 0-9.39.39A3 3 0 00.5 6.5 31.57 31.57 0 000 12a31.57 31.57 0 00.5 5.5 3 3 0 002.11 2.11C4.58 20 12 20 12 20s7.42 0 9.39-.39a3 3 0 002.11-2.11A31.57 31.57 0 0024 12a31.57 31.57 0 00-.5-5.5zm-13 9V8l6.5 3.5z" />
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

        <div x-data="{ tab: 'overview' }">
            {{-- Tabs --}}
            <div class="flex justify-center gap-2 mb-4 flex-wrap">
                <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                    class="px-4 py-2 rounded shadow flex items-center gap-2">
                    Overview
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 17L17 7M7 7h10v10" />
                    </svg>
                </button>
                <button @click="tab = 'info'" :class="tab === 'info' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                    class="px-4 py-2 rounded shadow flex items-center gap-2">
                    Notes
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 17L17 7M7 7h10v10" />
                    </svg>
                </button>
                <button @click="tab = 'terms'" :class="tab === 'terms' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                    class="px-4 py-2 rounded shadow flex items-center gap-2">
                    Itinerary
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
                        <h3 class="text-xl pace-y-2 text-gray-700 font-bold mb-4">Tour Price Includes:</h3>
                        <div class="prose prose-xs max-w-none text-gray-800">
                            {!! $tour->include !!}
                        </div>
                    </div>

                    {{-- Excludes --}}
                    <div class="md:border-l md:pl-6">
                        <h3 class="text-xl space-y-2 text-gray-700 font-bold mb-4">Tour Price Excludes:</h3>
                        <div class="prose prose-xs max-w-none text-gray-800">
                            {!! $tour->exclude !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- KANAN: Book A Trip --}}
            <div class="w-full md:w-2/4 bg-teal-100/30 rounded-lg p-6 flex-shrink-0">
                <h3 class="text-xl font-bold mb-4">Book A Trip:</h3>

                <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <input type="hidden" name="user_id" value="{{ Auth::user()?->id }}">
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                            <input type="text" name="name" id="name"
                                value="{{ Auth::user()->name ?? '' }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 transition placeholder-gray-400"
                                placeholder="Your full name" required>
                        </div>

                        {{-- City --}}
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City of Residence
                                *</label>
                            <input type="text" name="city" id="city"
                                value="{{ Auth::user()?->customer?->nationality }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 transition placeholder-gray-400 {{ Auth::check() ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                {{ Auth::check() ? 'readonly' : '' }} placeholder="City name" required>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" name="email" id="email"
                                value="{{ Auth::user()->email ?? '' }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 transition placeholder-gray-400"
                                placeholder="you@example.com" required>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number
                                *</label>
                            <input type="text" name="phone" id="phone"
                                value="{{ Auth::user()->customer->phone ?? '' }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 transition placeholder-gray-400"
                                placeholder="+62…" required>
                        </div>

                        {{-- Date --}}
                        <div>
                            <label for="travel_date" class="block text-sm font-medium text-gray-700">Date of Travel
                                *</label>
                            <input type="date" name="travel_date" id="travel_date"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 transition placeholder-gray-400"
                                required>
                        </div>

                        {{-- Packet --}}
                        <div>
                            <label for="packet" class="block text-sm font-medium text-gray-700">Packet *</label>
                            <select name="packet" id="packet"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 transition placeholder-gray-400"
                                required>
                                <option value="" disabled selected>Choose a packet</option>
                                @foreach ($tour->packet as $item)
                                    <option value="{{ $item['value'] }}">{{ $item['value'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Message --}}
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message *</label>
                        <textarea name="notes" id="message" rows="3"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 transition placeholder-gray-400"
                            placeholder="Write something about your trip…"></textarea>
                    </div>

                    {{-- Submit --}}
                    <div>
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center rounded-lg bg-lime-600 px-6 py-3 text-white font-semibold shadow-sm hover:bg-lime-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition">
                            Book Online
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    </div>

</x-guest-layout>
