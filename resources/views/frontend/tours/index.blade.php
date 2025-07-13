<x-guest-layout>
    @php
        $headerImage = imageOrDefault(app(\App\Settings\WebsiteSettings::class)->header_image, 'header');
    @endphp
    <section
        class="min-h-[300px] flex items-center justify-center bg-gradient-to-br from-indigo-600 to-blue-500 text-white relative overflow-hidden">
        @if ($headerImage)
            <img src="{{ $headerImage }}" alt="Header Image"
                class="absolute inset-0 w-full h-full object-cover opacity-5 z-0">
        @endif
        <div class="text-center z-10 px-4 max-w-2xl">
            <h1
                class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in-down
           bg-gradient-to-r from-white to-yellow-300 bg-clip-text text-transparent">
                Paket Tour
            </h1>
        </div>

        {{-- Optional Background Illustration --}}
        <div
            class="absolute inset-0 bg-[url('https://source.unsplash.com/featured/?travel')] bg-cover bg-center opacity-80">
        </div>
    </section>
    {{-- Paket Tour Section --}}
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">

            @if (\App\Models\Tour::count())
                <div class="grid gap-6 md:grid-cols-4" id="paket">
                    @foreach (\App\Models\Tour::get() as $tour)
                        <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg transform transition-all ease-in-out duration-300 hover:shadow-none hover:custom-rounded-br"
                            style="--tw-rounded-br: 60px;">

                            {{-- Gambar full --}}
                            <div class="overflow-hidden"> {{-- Tambahkan pembungkus supaya crop gambar ketika zoom --}}
                                <img src="{{ asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}"
                                    class="w-full h-96 object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110">
                            </div>

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
