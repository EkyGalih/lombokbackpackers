<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - {{ app(\App\Settings\WebsiteSettings::class)->site_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi masuk */
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
        <img src="{{ asset('defaults/login.jpg') }}" alt="Travel Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-cyan-900 bg-opacity-50"></div>
    </div>

    <div class="w-full max-w-3xl bg-white/50 shadow-lg rounded-lg p-8 animate-in">
        <h1 class="text-2xl font-bold text-center text-teal-600 mb-8">
            Daftar di {{ app(\App\Settings\WebsiteSettings::class)->site_name }}
        </h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nationality -->
                <div>
                    <label for="nationality" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                    <input id="nationality" type="text" name="nationality" value="{{ old('nationality') }}" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                    @error('nationality')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="gender" value="male"
                                {{ old('gender') == 'male' ? 'checked' : '' }} required
                                class="text-teal-600 focus:ring-teal-500">
                            <span class="ml-2">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="gender" value="female"
                                {{ old('gender') == 'female' ? 'checked' : '' }} required
                                class="text-teal-600 focus:ring-teal-500">
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div>
                    @error('gender')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                        required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                    @error('date_of_birth')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address (full-width) -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                    @error('address')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                        Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-teal-200 focus:border-teal-500" />
                </div>
            </div>

            <button type="submit"
                class="w-full mt-8 bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition transform duration-300 hover:scale-105">
                Daftar
            </button>

            <p class="mt-4 text-sm text-center text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-teal-600 hover:underline">Masuk di sini</a>
            </p>
        </form>
    </div>

    <p class="mt-6 text-xs text-gray-400 animate-in">
        &copy; {{ now()->year }} {{ app(\App\Settings\WebsiteSettings::class)->site_name }}. All rights reserved.
    </p>

</body>

</html>
