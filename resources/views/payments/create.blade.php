<x-app-layout>
    <div class="max-w-xl mx-auto py-12">
        <h2 class="text-2xl font-bold mb-6">Pembayaran untuk Booking {{ $booking->tour->title }}</h2>

        <form method="POST" action="{{ route('payments.store', $booking->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Jumlah Bayar</label>
                <input type="number" name="amount" value="{{ $booking->total_price }}" required class="w-full rounded border px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Metode Pembayaran</label>
                <select name="method" class="w-full rounded border px-4 py-2">
                    <option value="transfer">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Upload Bukti Transfer</label>
                <input type="file" name="proof_image" class="w-full rounded border px-4 py-2">
            </div>

            <button class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                Kirim Pembayaran
            </button>
        </form>
    </div>
</x-app-layout>
