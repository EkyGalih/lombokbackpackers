<x-app-layout>
    <div class="max-w-xl mx-auto py-12 px-4">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">
            Pembayaran untuk <span class="text-indigo-600">{{ $booking->tour->title }}</span>
        </h2>

        <form method="POST" action="{{ route('payments.payment', $booking->id) }}" enctype="multipart/form-data"
            x-data="{ preview: null }" class="space-y-6 bg-white shadow-lg rounded-xl p-6 animate-fade-in">
            @csrf

            {{-- Jumlah Bayar --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Jumlah Bayar</label>
                <input type="hidden" name="amount" value="{{ $booking->total_price }}" required
                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 px-4 py-2 shadow-sm transition"
                    readonly>
                <p class="text-lg font-bold text-teal-800 mt-1">
                    Rp. {{ number_format($booking->total_price, 0, ',', '.') }}
                </p>

            </div>

            {{-- Metode Pembayaran --}}
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Metode Pembayaran</label>
                <input type="hidden" name="payment_method"
                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 px-4 py-2 shadow-sm transition"
                    value="transfer">
                <div class="text-lg font-bold text-teal-800 mt-1">
                    Transfer
                </div>
                {{-- <select name="method"
                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 px-4 py-2 shadow-sm transition">
                    <option value="transfer">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                </select> --}}
            </div>

            {{-- Upload Bukti Transfer --}}
            <div x-data="{ preview: null }" class="flex flex-col gap-2">
                <label class="block text-sm font-semibold text-gray-600">Upload Bukti Transfer (PNG)</label>

                <!-- Custom Upload Button -->
                <label
                    class="relative cursor-pointer inline-flex items-center justify-center px-4 py-2 rounded-lg border border-dashed border-indigo-400 text-indigo-600 font-medium hover:bg-indigo-50 hover:shadow-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                    Pilih Bukti Transfer (PNG)
                    <input type="file" name="proof_image" accept="image/png"
                        class="absolute inset-0 opacity-0 cursor-pointer"
                        @change="
                if($event.target.files[0]){
                    const reader = new FileReader();
                    reader.onload = e => preview = e.target.result;
                    reader.readAsDataURL($event.target.files[0]);
                }
            ">
                </label>

                {{-- Error --}}
                @error('proof_image')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Preview -->
                <template x-if="preview">
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 mb-1">Preview:</p>
                        <img :src="preview" alt="Preview" class="w-full h-auto rounded-lg shadow border">
                    </div>
                </template>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-6 py-3 font-semibold shadow transition transform hover:-translate-y-0.5 hover:shadow-lg">
                Kirim Pembayaran
            </button>
        </form>
    </div>
</x-app-layout>
