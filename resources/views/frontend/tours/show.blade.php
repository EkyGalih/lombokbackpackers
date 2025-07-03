<x-guest-layout>
    <section class="bg-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $tour->title }}</h1>
            <p class="text-gray-600 mb-6">{{ $tour->description }}</p>

            <div class="mb-4">
                <p class="text-lg"><strong>Harga:</strong> Rp {{ number_format($tour->price, 0, ',', '.') }}</p>
                <p class="text-lg"><strong>Durasi:</strong> {{ $tour->duration }} hari</p>
            </div>

            @auth
                <form action="{{ route('bookings.store') }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                    <label for="booking_date" class="block text-sm text-gray-600 mb-1">Tanggal Keberangkatan:</label>
                    <input type="date" name="booking_date" required class="border rounded w-full py-2 px-3 mb-4">

                    <button class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Booking Sekarang
                    </button>
                </form>
            @else
                <p class="mt-6 text-gray-700">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a> untuk melakukan
                    booking.
                </p>
            @endauth
        </div>
    </section>
</x-guest-layout>
