<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ app(\App\Settings\WebsiteSettings::class)->favicon }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-gray-800">
    <div class="min-h-screen flex flex-col">
        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Header --}}
        @isset($header)
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <h1 class="text-xl sm:text-2xl font-semibold text-slate-700">{{ $header }}</h1>
                </div>
            </header>
        @endisset

        {{-- Main Content --}}
        <main class="flex-1">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        {{-- Footer (opsional) --}}
        <footer class="bg-white shadow-inner mt-6">
            <div class="max-w-7xl mx-auto px-4 py-4 text-center text-sm text-gray-500">
                &copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.
            </div>
        </footer>
    </div>

    {{-- Midtrans --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        function payNow(bookingId) {
            fetch(`/midtrans/token/${bookingId}`)
                .then(res => res.json())
                .then(data => {
                    window.snap.pay(data.token, {
                        onSuccess: function(result) {
                            alert('Pembayaran berhasil');
                            window.location.reload();
                        },
                        onPending: function(result) {
                            alert('Menunggu pembayaran');
                            window.location.reload();
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal');
                        },
                        onClose: function() {
                            alert('Kamu menutup popup tanpa menyelesaikan pembayaran');
                        }
                    });
                });
        }
    </script>
</body>

</html>
