@section('seoMeta')
    <x-seo-meta :meta="$seoMeta" />
@endsection

<x-guest-layout>
    <x-slot name="nav">
        <x-header title="{{ $tour->title }}" breadcrumb="Destination > {{ $tour->category->name }}"
            image="{{ $tour->media?->first()->url }}" alt="{{ $tour->name }}" />
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
                    <p class="text-gray-800 font-semibold rounded border border-gray-200 px-3 py-2 text-justify" style="border-radius: 0.25rem;">
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
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center rounded-full border text-gray-800 hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"
                                viewBox="0 0 24 24">
                                <path
                                    d="M22,12A10,10,0,1,0,10.93,21.94V14.89H8v-2.9h2.93V9.35c0-2.89,1.72-4.49,4.35-4.49a17.58,17.58,0,0,1,2.57.22v2.83H16.86c-1.46,0-1.92.91-1.92,1.85v2.22h3.27l-.52,2.9H14.94v7.05A10,10,0,0,0,22,12Z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center rounded-full border text-gray-800 hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"
                                viewBox="0 0 24 24">
                                <path
                                    d="M22.46 6c-.77.35-1.6.58-2.46.69A4.27 4.27 0 0021.86 4c-.83.49-1.75.84-2.72 1a4.26 4.26 0 00-7.26 3.89A12.07 12.07 0 013 5.12a4.26 4.26 0 001.32 5.7 4.23 4.23 0 01-1.93-.53v.05a4.27 4.27 0 003.42 4.18 4.3 4.3 0 01-1.92.07 4.27 4.27 0 003.99 2.97A8.57 8.57 0 012 19.54a12.06 12.06 0 006.55 1.92c7.87 0 12.18-6.52 12.18-12.18 0-.19 0-.37-.01-.56A8.72 8.72 0 0024 6.51a8.48 8.48 0 01-2.54.7A4.23 4.23 0 0022.46 6z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center rounded-full border text-gray-800 hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"
                                viewBox="0 0 24 24">
                                <path
                                    d="M8.72 13.74L0 24h6.44l4.14-4.89 6.16 4.89H24L15.29 12 24 0h-6.44l-4.14 4.89L7.26 0H0l8.72 12z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center rounded-full border text-gray-800 hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"
                                viewBox="0 0 24 24">
                                <path
                                    d="M23.5 6.5a3 3 0 00-2.11-2.11C19.42 4 12 4 12 4s-7.42 0-9.39.39A3 3 0 00.5 6.5 31.57 31.57 0 000 12a31.57 31.57 0 00.5 5.5 3 3 0 002.11 2.11C4.58 20 12 20 12 20s7.42 0 9.39-.39a3 3 0 002.11-2.11A31.57 31.57 0 0024 12a31.57 31.57 0 00-.5-5.5zm-13 9V8l6.5 3.5z" />
                            </svg>
                        </a>

                    </div>
                    <div class="flex">
                        <a href="#booking"
                            class="bg-lime-300 hover:bg-lime-400 text-gray-900 font-semibold px-4 py-2 rounded-full shadow">
                            Enquiry Now
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4">
            {{-- Subtitle + Title --}}
            <h2 class="text-3xl md:text-4xl font-extrabold text-center text-gray-800 mb-6">
                Detail Tour
            </h2>

            <div x-data="{ tab: 'overview' }">
                {{-- Tabs --}}
                <div class="flex justify-center gap-2 mb-4 flex-wrap">
                    <button @click="tab = 'overview'"
                        :class="tab === 'overview' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                        class="px-4 py-2 rounded shadow">
                        Overview
                    </button>
                    <button @click="tab = 'info'" :class="tab === 'info' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                        class="px-4 py-2 rounded shadow">
                        Notes
                    </button>
                    <button @click="tab = 'terms'"
                        :class="tab === 'terms' ? 'bg-teal-900 text-white' : 'bg-lime-400'"
                        class="px-4 py-2 rounded shadow">
                        Itinerary
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
                            <div class="bg-white rounded-lg border p-4 md:p-6 flex flex-col md:flex-row gap-6">
                                {{-- Left: Itinerary --}}
                                <div class="flex-1 text-sm">
                                    {!! $tour->description !!}
                                </div>

                                {{-- Right: Image --}}
                                <div class="flex-1">
                                    <img src="{{ $tour->media?->first()->url }}" alt="{{ $tour->title }}"
                                        class="rounded-lg shadow object-cover w-full h-full">
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
                            <div class="bg-white rounded-lg border p-4 md:p-6 flex flex-col md:flex-row gap-6">
                                {{-- Left: Itinerary --}}
                                <div class="flex-1 text-sm">
                                    {!! $tour->notes !!}
                                </div>

                                {{-- Right: Image --}}
                                <div class="flex-1">
                                    <img src="{{ $tour->media?->first()->url }}" alt="{{ $tour->title }}"
                                        class="rounded-lg shadow object-cover w-full h-full">
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
                            <div class="bg-white rounded-lg border p-4 md:p-6 flex flex-col md:flex-row gap-6">
                                {{-- Left: Itinerary --}}
                                <div class="flex-1 text-sm">
                                    {!! $tour->itinerary !!}
                                </div>

                                {{-- Right: Image --}}
                                <div class="flex-1">
                                    <img src="{{ $tour->media?->first()->url }}" alt="{{ $tour->title }}"
                                        class="rounded-lg shadow object-cover w-full h-full">
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
                            <h3 class="text-xl font-bold mb-4">Tour Price Includes:</h3>
                            <ul class="space-y-2 text-sm text-gray-700">
                                {!! $tour->include !!}
                            </ul>
                        </div>

                        {{-- Excludes --}}
                        <div class="md:border-l md:pl-6">
                            <h3 class="text-xl font-bold mb-4">Tour Price Excludes:</h3>
                            <ul class="space-y-2 text-sm text-gray-700">
                                {!! $tour->exclude !!}
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- KANAN: Book A Trip --}}
                <div class="w-full md:w-2/4 bg-blue-100 rounded-lg p-6 flex-shrink-0">
                    <h3 class="text-xl font-bold mb-4">Book A Trip:</h3>

                    <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Name *"
                                class="border border-gray-300 rounded px-3 py-2 w-full" required>
                            <input type="text" name="city" placeholder="City of Residence *"
                                class="border border-gray-300 rounded px-3 py-2 w-full" required>

                            <input type="email" name="email" placeholder="Email *"
                                class="border border-gray-300 rounded px-3 py-2 w-full" required>
                            <input type="text" name="phone" placeholder="Phone Number *"
                                class="border border-gray-300 rounded px-3 py-2 w-full" required>

                            <input type="date" name="travel_date" placeholder="Date of Travel *"
                                class="border border-gray-300 rounded px-3 py-2 w-full" required>
                            <input type="number" name="people" placeholder="No of People *"
                                class="border border-gray-300 rounded px-3 py-2 w-full" min="1" required>
                        </div>

                        <textarea name="message" rows="3" placeholder="Message *"
                            class="border border-gray-300 rounded px-3 py-2 w-full"></textarea>

                        <button type="submit"
                            class="bg-teal-900 hover:bg-teal-800 text-white rounded-full px-6 py-2 w-full font-semibold">
                            Book Online
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </div>

</x-guest-layout>
