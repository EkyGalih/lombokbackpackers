<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Travelnesia') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-600 to-indigo-700 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-8 bg-white/90 backdrop-blur-md rounded-xl shadow-xl">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Travelnesia</h1>
            <p class="text-sm text-gray-500">Tour & Travel System</p>
        </div>

        {{ $slot }}
    </div>

</body>
</html>
