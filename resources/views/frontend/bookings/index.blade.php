<x-app-layout>
    <div class="max-w-7xl mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6">Daftar Booking Anda</h2>

        @if ($bookings->count())
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full table-auto border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-600">
                            <th class="p-4">Tour</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Pembayaran</th>
                            <th class="p-4">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr class="border-t text-sm text-gray-700">
                                <td class="p-4">{{ $booking->tour->title }}</td>
                                <td class="p-4">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                </td>
                                <td class="p-4">
                                    <span
                                        class="px-2 py-1 rounded text-white text-xs
                                            @switch($booking->status)
                                                @case('approved') bg-green-600 @break
                                                @case('pending') bg-yellow-500 @break
                                                @case('waiting') bg-gray-600 @break
                                                @case('rejected') bg-red-600 @break
                                                @default bg-gray-400
                                            @endswitch
                                        ">
                                        {{ $booking->status->label() }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if ($booking->payment)
                                        <span class="text-green-600 font-semibold">Sudah Bayar</span>
                                    @else
                                        <span class="text-gray-500 italic">Belum</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if ($booking->payment)
                                        <span class="text-green-600 font-semibold">Sudah Bayar</span>
                                    @else
                                        @if ($booking->status === App\Enums\BookingStatus::Pending)
                                            <button onclick="payNow('{{ $booking->id }}')"
                                                class="bg-indigo-600 text-white px-3 py-1 text-sm rounded hover:bg-indigo-700">
                                                Bayar Sekarang
                                            </button>
                                        @else
                                            <span class="text-gray-500 italic">Belum</span>
                                        @endif
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
            <p class="text-gray-500">Anda belum memiliki booking.</p>
        @endif
    </div>
</x-app-layout>
