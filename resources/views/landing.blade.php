<x-guest-layout>
    {{-- Hero Section --}}
    @php
        $headerImage = app(\App\Settings\WebsiteSettings::class)->header_image;
        $headerTitle = app(\App\Settings\WebsiteSettings::class)->header_title;
        $headerSubTitle = app(\App\Settings\WebsiteSettings::class)->header_sub_title;
    @endphp
    <section
        class="h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 to-blue-500 text-white relative overflow-hidden">
        @if ($headerImage)
            <img src="{{ asset('storage/' . $headerImage) }}" alt="Header Image"
                class="absolute inset-0 w-full h-full object-cover opacity-30 z-0">
        @endif
        <div class="text-center z-10 px-4 max-w-2xl">
            <h1
                class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in-down
           bg-gradient-to-r from-white to-yellow-300 bg-clip-text text-transparent">
                {{ $headerTitle }}
            </h1>
            <p class="text-lg md:text-xl mb-8 animate-fade-in-up">
                {{ $headerSubTitle }}
            </p>
            @guest
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">
                        Explore
                    </a>
                </div>
            @endguest
        </div>

        {{-- Optional Background Illustration --}}
        <div
            class="absolute inset-0 bg-[url('https://source.unsplash.com/featured/?travel')] bg-cover bg-center opacity-20">
        </div>
    </section>

    {{-- Paket Tour Section --}}
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-8 text-gray-800">Paket Tour Unggulan</h2>

            @if (\App\Models\Tour::count())
                <div class="grid gap-6 md:grid-cols-3" id="paket">
                    @foreach (\App\Models\Tour::take(3)->get() as $tour)
                        <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg transform transition-all ease-in-out duration-300 hover:shadow-none hover:custom-rounded-br"
                            style="--tw-rounded-br: 60px;">


                            {{-- Gambar full --}}
                            <img src="{{ asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}"
                                class="w-full h-96 object-cover">

                            {{-- Overlay tulisan di bawah --}}
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 z-20">
                                <div class="transition-transform duration-300 ease-out group-hover:scale-105">
                                    <h3 class="text-lg font-semibold text-white">
                                        {{ $tour->title }}
                                    </h3>

                                    @if ($tour->discount && $tour->discount > 0)
                                        <p class="text-sm text-gray-300 line-through">
                                            Rp {{ number_format($tour->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xl text-red-400 font-bold">
                                            Rp {{ number_format($tour->price - $tour->discount, 0, ',', '.') }}
                                        </p>
                                        <small class="text-gray-300 text-xs">{{ $tour->package_person_count }}
                                            Person</small>
                                    @else
                                        <p class="text-xl font-semibold text-indigo-300">
                                            Rp {{ number_format($tour->price, 0, ',', '.') }}
                                        </p>
                                        <small class="text-gray-300 text-xs">{{ $tour->package_person_count }}
                                            Person</small>
                                    @endif
                                </div>
                            </div>

                            {{-- Tombol Book Now tampil saat hover --}}
                            <div
                                class="absolute inset-0 flex justify-center items-center opacity-0 group-hover:opacity-100 bg-black bg-opacity-50 transition duration-300 z-10">
                                <a href="{{ route('tours.show', $tour->slug) }}"
                                    class="text-indigo-300 text-lg font-bold hover:underline hover:text-white transition">
                                    Browse Trips
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Belum ada paket tour tersedia.</p>
            @endif

        </div>
    </section>
</x-guest-layout>
