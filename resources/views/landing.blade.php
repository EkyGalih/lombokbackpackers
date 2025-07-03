<x-guest-layout>
    {{-- Hero Section --}}
    <section class="h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 to-blue-500 text-white relative overflow-hidden">
        <div class="text-center z-10 px-4 max-w-2xl">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in-down">
                Jelajahi Dunia Bersama <span class="text-yellow-300">Travelnesia</span>
            </h1>
            <p class="text-lg md:text-xl mb-8 animate-fade-in-up">
                Temukan paket tour terbaik, booking online, dan nikmati petualangan tak terlupakan.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('login') }}" class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 font-semibold px-6 py-3 rounded-lg shadow hover:bg-yellow-300 transition">
                    Daftar
                </a>
            </div>
        </div>

        {{-- Optional Background Illustration --}}
        <div class="absolute inset-0 bg-[url('https://source.unsplash.com/featured/?travel')] bg-cover bg-center opacity-20"></div>
    </section>

    {{-- Paket Tour Section --}}
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-8 text-gray-800">Paket Tour Unggulan</h2>

            @if (\App\Models\Tour::count())
                <div class="grid gap-6 md:grid-cols-3" id="paket">
                    @foreach (\App\Models\Tour::take(3)->get() as $tour)
                        <div class="bg-white shadow rounded-lg p-6 text-left transition hover:scale-105 duration-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $tour->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ \Str::limit($tour->description, 100) }}</p>
                            <p class="text-indigo-600 font-bold mb-4">Rp {{ number_format($tour->price, 0, ',', '.') }}</p>
                            <a href="{{ route('tours.show', $tour->slug) }}"
                                class="inline-block text-sm text-white bg-indigo-600 px-4 py-2 rounded hover:bg-indigo-700 transition">
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
</x-guest-layout>
