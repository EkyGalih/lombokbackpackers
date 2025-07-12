@php
    $booking = $getRecord();
    $payment = $booking?->payment;
@endphp
{{-- {{ dd($payment) }} --}}

@if ($payment && $payment->payment_proof)
    <div x-data="{ open: false }">
        <label for="title" class="mb-4 block">Bukti Pembayaran</label>
        <img src="{{ asset('storage/' . $payment->payment_proof) }}"
            class="rounded shadow cursor-pointer w-20 h-40 object-cover" @click="open = true">

        <div x-show="open" x-cloak @keydown.escape.window="open = false" @click.self="open = false"
            class="fixed inset-0 z-50 bg-black/75 flex items-center justify-center p-4">
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90" class="relative">
                <button @click="open = false"
                    class="absolute top-0 right-0 mt-2 mr-2 text-white text-3xl font-bold z-10 hover:text-red-400 transition">
                    &times;
                </button>

                <img src="{{ asset('storage/' . $payment->payment_proof) }}"
                    class="rounded shadow-lg max-h-[90vh] max-w-full border-4 border-white">
            </div>
        </div>
    </div>
@endif
