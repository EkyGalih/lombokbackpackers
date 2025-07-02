<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Daftar Booking Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="overflow-x-auto bg-white shadow-md rounded-xl">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-xs text-gray-600 uppercase">
                        <tr>
                            <th class="px-6 py-3">Paket Tour</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $booking->tour->title }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                <td class="px-6 py-4">{{ ucfirst($booking->status) }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('bookings.show', $booking->id) }}"
                                        class="text-blue-600 hover:underline">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">Belum ada booking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
