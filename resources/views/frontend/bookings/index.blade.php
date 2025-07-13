<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Daftar Booking Anda</h2>

        @if ($bookings->count())
            <div class="overflow-x-auto bg-white shadow rounded-lg animate-fade-in">
                <table class="min-w-full table-auto border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50 text-left text-sm font-medium text-gray-700">
                            <th class="p-4">Tour</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Pembayaran</th>
                            <th class="p-4">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr
                                class="border-t text-sm text-gray-700 hover:bg-gray-50 transition-all duration-200 ease-in-out hover:scale-[1]">
                                <td class="p-4">{{ $booking->tour->title }}</td>
                                <td class="p-4">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                </td>
                                <td class="p-4">
                                    <span
                                        class="px-2 py-1 rounded text-xs font-medium
                                            @switch($booking->status)
                                                @case('approved') bg-green-100 text-green-800 @break
                                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                                @case('waiting') bg-gray-200 text-gray-800 @break
                                                @case('rejected') bg-red-100 text-red-800 @break
                                                @default bg-gray-100 text-gray-700
                                            @endswitch
                                        ">
                                        {{ $booking->status->label() }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if ($booking->payment)
                                        <span class="text-green-700 font-medium">Sudah Bayar</span>
                                    @else
                                        <span class="text-gray-500 italic">Belum Bayar</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if ($booking->status == \App\Enums\BookingStatus::Approved)
                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                            class="inline-block bg-teal-600 text-white px-3 py-1 text-sm rounded hover:bg-teal-700 transform hover:scale-105 transition-all duration-150">
                                            Invoice
                                        </a>
                                    @elseif ($booking->status === App\Enums\BookingStatus::Pending)
                                        <a href="{{ route('payments.create', $booking->id) }}"
                                            class="inline-block bg-indigo-600 text-white px-3 py-1 text-sm rounded hover:bg-indigo-700 transform hover:scale-105 transition-all duration-150">
                                            Bayar Sekarang
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @else
            <p class="text-gray-500 animate-fade-in">Anda belum memiliki booking.</p>
        @endif

        <h2 class="text-2xl font-semibold text-gray-800 mt-10">Tour Tersedia</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($tours as $tour)
                <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-md transition">
                    <img src="{{ $tour->media?->first()?->url ?? asset('images/default-tour.jpg') }}" alt="{{ $tour->title }}"
                        class="h-40 w-full object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $tour->title }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ $tour->category->name ?? '-' }}
                        </p>
                        <div class="mt-2 flex justify-between items-center">
                            <p class="text-teal-600 font-bold">
                                From Starts Rp {{ number_format($tour->lowest_price, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('tours.show', $tour->slug) }}"
                                class="px-3 py-1 text-xs bg-teal-600 text-white rounded hover:bg-lime-700">
                                Lihat Detail
                            </a>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('tours.show', $tour->slug) }}"
                                class="block text-center text-sm mt-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                Booking Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada tour yang tersedia saat ini.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
