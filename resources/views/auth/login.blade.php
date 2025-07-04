<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ app(\App\Settings\WebsiteSettings::class)->site_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center">

    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-center text-indigo-600 mb-6">
            Masuk ke {{ app(\App\Settings\WebsiteSettings::class)->site_name }}
        </h1>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>

                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Lupa
                    Password?</a>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition">
                Masuk
            </button>

            <p class="mt-6 text-sm text-center text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar sekarang</a>
            </p>
        </form>
    </div>

    <p class="mt-6 text-xs text-gray-400">
        &copy; {{ now()->year }} {{ app(\App\Settings\WebsiteSettings::class)->site_name }}. All rights reserved.
    </p>

</body>

</html>
