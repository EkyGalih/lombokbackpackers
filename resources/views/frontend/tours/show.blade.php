<x-guest-layout title="Tour - {{ config('app.name') }}">
    <section class="bg-gray-50 py-12">
        <div class="max-w-5xl mx-auto px-4">

            {{-- Hero Image --}}
            @if ($tour->thumbnail)
                <div class="overflow-hidden rounded-lg shadow-md mb-8 mt-8">
                    <img src="{{ asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}"
                        class="w-full h-64 md:h-96 object-cover">
                </div>
            @endif

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

            {{-- Description --}}
            <p class="text-gray-600 text-lg mb-8">{{ $tour->description }}</p>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-sm text-gray-500">Harga</p>
                    @if ($tour->discount && $tour->discount > 0)
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
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-sm text-gray-500">Durasi</p>
                    <p class="text-2xl font-semibold text-indigo-600">
                        {{ $tour->duration }} Hari
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p class="text-xl font-semibold text-gray-700">
                        {{ $tour->category->name ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- Booking Form --}}
            <div class="bg-white rounded-lg shadow p-6">
                @auth
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Booking Sekarang</h2>

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tour_id" value="{{ $tour->id }}">

                        <div class="mb-4">
                            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Pilih Tanggal Keberangkatan
                            </label>
                            <input type="date" name="booking_date" required
                                class="border border-gray-300 rounded w-full py-2 px-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <button type="submit"
                            class="w-full md:w-auto bg-gradient-to-r from-indigo-500 to-indigo-700 hover:from-indigo-600 hover:to-indigo-800 text-indigo-800 font-semibold py-2 px-6 rounded shadow-md transition">
                            🚤 Booking Sekarang
                        </button>
                    </form>
                @else
                    <p class="text-gray-700 text-center">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">
                            Login
                        </a> untuk melakukan booking.
                    </p>
                @endauth
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
                @else
                    <p class="mt-6 text-gray-700">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a> untuk memberi
                        rating & ulasan.
                    </p>
            @endif

        </div>
    </section>
</x-guest-layout>
