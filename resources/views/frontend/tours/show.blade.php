@section('seoMeta')
    <x-seo-meta :meta="$seoMeta" />
@endsection

<x-guest-layout>
    <section
        class="min-h-[500px] flex items-center justify-center bg-gradient-to-br from-lime-600 to-lime-500 text-white relative overflow-hidden">
        @if ($tour->media?->first())
            {{-- Tour Image --}}
            <img src="{{ $tour->media?->first()->url }}" alt="{{ $tour->title }}"
                class="absolute inset-0 w-full h-full object-cover opacity-90 z-0">
        @endif

        {{-- Optional Background Illustration --}}
        <div
            class="absolute inset-0 bg-[url('https://source.unsplash.com/featured/?travel')] bg-cover bg-center opacity-80">
        </div>
    </section>

    <section class="bg-gray-50 py-12">
        <div class="max-w-5xl mx-auto px-4">
            {{-- Title & Status --}}
            <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2 md:mb-0">
                    {{ $tour->title }}
                </h1>

                {{-- Rating --}}
                <div class="text-center">
                    <p class="text-sm text-gray-500">Rating</p>
                    <p class="text-xl font-semibold text-yellow-500">
                        ⭐ {{ $tour->rating }} ({{ $tour->reviews_count }} ulasan)
                    </p>
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-sm text-gray-500">Paket</p>
                    @foreach ($tour->packet as $packet)
                        <div class="flex flex-col items-center mb-1">
                            <span
                                class="inline-block bg-lime-300 text-slate-900 px-2 py-0.5 rounded-full text-sm font-medium mb-0.5 shadow-sm">
                                {{ $packet['value'] }}
                            </span>
                        </div>
                    @endforeach
                    {{-- @if ($tour->discount && $tour->discount > 0)
                        <p class="text-sm text-gray-400 line-through">
                            Rp
                            {{ number_format($tour->price, 0, ',', '.') }}
                        </p>
                        <p class="text-xl font-bold text-red-600">
                            Rp
                            {{ number_format($tour->price - $tour->discount, 0, ',', '.') }}
                        </p>
                        <small class="text-gray-500 text-xs">{{ $tour->package_person_count }} Person</small>
                    @else
                        <p class="text-xl font-semibold text-indigo-600">
                            Rp
                            {{ number_format($tour->price, 0, ',', '.') }}
                        </p>
                        <small class="text-gray-500 text-xs">{{ $tour->package_person_count }} Person</small>
                    @endif --}}
                </div>

                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-sm text-gray-500">Durasi</p>
                    <p class="text-2xl font-semibold text-lime-600">
                        {{ $tour->duration }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p class="text-xl font-semibold text-gray-700">
                        {{ $tour->category->name ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- detail tabs --}}
            <div x-data="{ tab: 'overview' }">
                <div class="border-b mb-4">
                    <nav class="flex justify-between items-center">
                        <button
                            :class="tab === 'overview' ? 'border-b-2 border-lime-500 text-lime-600' : 'text-gray-600'"
                            class="py-2 px-4 focus:outline-none" @click="tab = 'overview'">
                            Overview
                        </button>
                        <button
                            :class="tab === 'inc/exc' ? 'border-b-2 border-lime-500 text-lime-600' : 'text-gray-600'"
                            class="py-2 px-4 focus:outline-none" @click="tab = 'inc/exc'">
                            Inc/Exc
                        </button>
                        <button
                            :class="tab === 'itinerary' ? 'border-b-2 border-lime-500 text-lime-600' : 'text-gray-600'"
                            class="py-2 px-4 focus:outline-none" @click="tab = 'itinerary'">
                            Itinerary
                        </button>
                        {{-- Booking Form --}}
                        <div class="ml-auto flex items-center">
                            @auth
                                <div x-data="{ open: false }">
                                    <!-- Tombol -->
                                    <button @click="open = true"
                                        class="border border-lime-500 font-semibold py-2 px-4 rounded shadow-md transition text-sm ml-2 text-lime-600 hover:bg-lime-50">
                                        Booking Sekarang
                                    </button>

                                    <!-- Modal -->
                                    <div x-show="open" x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                        <div @click.away="open = false"
                                            class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                            <h2 class="text-xl font-bold text-gray-800 mb-4">Booking Sekarang</h2>

                                            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                                                @csrf
                                                <input type="hidden" name="tour_id" value="{{ $tour->id }}">

                                                <div>
                                                    <label for="booking_date"
                                                        class="block text-sm font-medium text-gray-700">Tanggal
                                                        Booking</label>
                                                    <input type="date" id="booking_date" name="booking_date" required
                                                        class="mt-1 block w-full border border-gray-300 rounded py-2 px-3 shadow-sm focus:ring-lime-500 focus:border-lime-500 text-sm">
                                                </div>

                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" @click="open = false"
                                                        class="py-2 px-4 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-sm">
                                                        Batal
                                                    </button>

                                                    <button type="submit"
                                                        class="py-2 px-4 bg-lime-500 hover:bg-lime-600 text-white font-semibold rounded shadow text-sm">
                                                        Booking
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('register') }}"
                                    class="border border-lime-500 border-b-1 border-t-1 border-l-1 border-r-1 bg-1 font-semibold py-2 px-4 rounded shadow-md transition text-sm ml-2 text-lime-600 hover:bg-lime-50">
                                    Booking Sekarang
                                </a>
                            @endauth
                        </div>
                    </nav>
                </div>

                <div x-show="tab === 'overview'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2" x-cloak>
                    <h4 class="font-bold">Overview:</h4>
                    <p class="text-slate-900 mb-4">
                        {!! $tour->description !!}
                    </p>
                    <h4 class="font-bold mt-4">Notes:</h4>
                    <p class="text-slate-900 mb-4">
                        {!! $tour->notes !!}
                    </p>
                </div>

                <div x-show="tab === 'inc/exc'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2" x-cloak>
                    <h4 class="font-bold mt-4">Include:</h4>
                    <p class="text-slate-900 mb-4">
                        {!! $tour->include !!}
                    </p>
                    <h4 class="font-bold mt-4">Exclude:</h4>
                    <p class="text-slate-900 mb-4">
                        {!! $tour->exclude !!}
                    </p>
                </div>

                <div x-show="tab === 'itinerary'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2" x-cloak>
                    <h4 class="font-bold mt-4">Itinerary:</h4>
                    <p class="text-slate-900 mb-4">
                        {!! $tour->itinerary !!}
                    </p>
                </div>
            </div>

            @if ($tour->ratings->count())
                <div class="mt-8">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Ulasan Pengguna:</h2>

                    @foreach ($tour->ratings->take(3) as $rating)
                        <div class="mb-4 p-4 bg-gray-50 rounded shadow-sm">
                            <div class="flex items-center mb-1">
                                <div class="text-yellow-400 text-lg">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $rating->rating ? '⭐' : '☆' }}</span>
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm text-gray">oleh {{ $rating->user->name }}</span>
                            </div>
                            <p class="text-gray-700">{{ $rating->comment }}</p>
                        </div>
                    @endforeach

                    @if ($tour->ratings->count() > 3)
                        <form method="GET" action="{{ route('tours.show', $tour) }}">
                            <input type="hidden" name="show_all_reviews" value="1">
                            <button class="mt-4 text-indigo-600 hover:underline font-medium" type="submit">
                                Tampilkan semua ulasan ({{ $tour->ratings->count() }})
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            @if (auth()->check())
                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-2">Berikan Rating & Ulasan Anda:</h2>

                    @php
                        $myRating = $tour->ratings->where('user_id', auth()->id())->first();
                    @endphp

                    <form action="{{ route('tours.rate', $tour->id) }}" method="POST" class="mt-6"
                        x-data="{ rating: 0 }">
                        @csrf
                        <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                        <input type="hidden" name="rating" :value="rating">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Beri Rating &amp; Ulasan
                            </label>
                            <div class="flex space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg @click="rating = {{ $i }}" xmlns="http://www.w3.org/2000/svg"
                                        class="h-8 w-8 cursor-pointer"
                                        :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.184c.969 0 1.371 1.24.588 1.81l-3.39 2.463a1 1 0 00-.364 1.118l1.286 3.974c.3.921-.755 1.688-1.54 1.118l-3.39-2.463a1 1 0 00-1.176 0l-3.39 2.463c-.784.57-1.838-.197-1.539-1.118l1.285-3.974a1 1 0 00-.364-1.118L2.05 9.401c-.783-.57-.38-1.81.588-1.81h4.184a1 1 0 00.95-.69l1.286-3.974z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-4">
                            <textarea name="comment" rows="3"
                                class="border border-gray-300 rounded w-full py-2 px-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Tulis ulasan Anda di sini (optional)"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded transition">
                                Kirim
                            </button>
                        </div>
                    </form>
            @endif

        </div>
    </section>
</x-guest-layout>
