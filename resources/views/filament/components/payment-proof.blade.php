@php
    $booking = $getRecord();
    $payment = $booking?->payment;
@endphp

@if ($payment && $payment->proof_image)
    <div x-data="{ open: false }">
        <img
            src="{{ asset('storage/' . $payment->proof_image) }}"
            class="rounded shadow cursor-pointer max-w-full h-auto"
            @click="console.log('Clicked!'); open = true"
        >

        <div
            x-show="open"
            x-cloak
            @keydown.escape.window="open = false"
            @click.self="open = false"
            x-transition.opacity
            class="fixed inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center p-4"
        >
            <div class="relative">
                <button
                    @click="open = false"
                    class="absolute top-0 right-0 mt-2 mr-2 text-white text-3xl font-bold z-10"
                >
                    &times;
                </button>

                <img
                    src="{{ asset('storage/' . $payment->proof_image) }}"
                    class="rounded shadow-lg max-h-[90vh] max-w-full border-4 border-white"
                >
            </div>
        </div>
    </div>
@endif
