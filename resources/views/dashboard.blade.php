<x-app-layout>
    <div class="container mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6">Dashboard Saya</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 bg-white shadow rounded-xl">
                <h3 class="text-xl font-semibold">Total Booking</h3>
                <p class="text-3xl mt-2">{{ auth()->user()->bookings()->count() }}</p>
            </div>

            <div class="p-6 bg-white shadow rounded-xl">
                <h3 class="text-xl font-semibold">Total Pembayaran</h3>
                <p class="text-3xl mt-2">Rp
                    {{ number_format(auth()->user()->bookings()->sum('total_price'), 0, ',', '.') }}</p>
            </div>

            {{-- @if ($booking->status === 'approved')
                <a href="{{ route('invoice.download', $booking->id) }}" class="text-sm text-indigo-600 hover:underline">
                    Download Invoice
                </a>
            @endif --}}

        </div>
    </div>
</x-app-layout>
