<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ app(\App\Settings\WebsiteSettings::class)->site_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeSlideUp 0.7s ease forwards;
        }

        button:hover {
            transform: scale(1.03);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col justify-center items-center relative">

    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ asset('defaults/login.jpg') }}" alt="Travel Background"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-cyan-900 bg-opacity-50"></div>
    </div>

    <!-- Overlay Text -->
    <div class="absolute top-12 text-center text-white px-4 animate-in">
        <h1 class="text-4xl font-bold">{{ app(\App\Settings\WebsiteSettings::class)->site_name }}</h1>
        <p class="mt-2 text-lg">Selamat datang kembali, lanjutkan petualanganmu bersama kami.</p>
    </div>

    <!-- Form -->
    <div class="relative w-full max-w-md bg-white/50 shadow-lg rounded-lg p-6 animate-in z-10">
        <h2 class="text-2xl font-bold text-center text-teal-600 mb-6">
            Masuk
        </h2>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 animate-in">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>

                <a href="{{ route('password.request') }}" class="text-sm text-teal-600 hover:underline">Lupa
                    Password?</a>
            </div>

            <button type="submit"
                class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition transform duration-300 hover:scale-105">
                Masuk
            </button>

            <p class="mt-6 text-sm text-center text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-teal-600 hover:underline">Daftar sekarang</a>
            </p>
        </form>
    </div>

    <p class="mt-6 text-xs text-gray-200 relative z-10">
        &copy; {{ now()->year }} {{ app(\App\Settings\WebsiteSettings::class)->site_name }}. All rights reserved.
    </p>

</body>

</html>
