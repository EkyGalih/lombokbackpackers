<x-guest-layout>
    <section class="bg-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-800 leading-tight">
                Jelajahi Dunia Bersama <span class="text-indigo-600">Travelnesia</span>
            </h1>
            <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan paket tour terbaik, booking online, dan nikmati petualangan tak terlupakan.
            </p>
            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300">
                    Daftar
                </a>
            </div>
        </div>
    </section>

    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-8 text-gray-800">Paket Tour Unggulan</h2>

            @if(\App\Models\Tour::count())
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach (\App\Models\Tour::take(3)->get() as $tour)
                        <div class="bg-white shadow rounded-lg p-6 text-left">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $tour->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ \Str::limit($tour->description, 100) }}</p>
                            <p class="text-indigo-600 font-bold mb-4">Rp {{ number_format($tour->price, 0, ',', '.') }}</p>
                            <a href="{{ route('login') }}" class="inline-block text-sm text-white bg-indigo-600 px-4 py-2 rounded hover:bg-indigo-700">
                                Lihat Detail
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Belum ada paket tour tersedia.</p>
            @endif
        </div>
    </section>

    <footer class="bg-white py-6 mt-10 text-center text-gray-500 text-sm">
        &copy; {{ now()->year }} Travelnesia. All rights reserved.
    </footer>
</x-guest-layout>
