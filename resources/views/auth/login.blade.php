<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" class="mt-1 w-full rounded border-gray-300 shadow-sm" type="email" name="email"
                required autofocus />
            @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" class="mt-1 w-full rounded border-gray-300 shadow-sm" type="password" name="password"
                required />
            @error('password')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Lupa Password?</a>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
            Masuk
        </button>

        <p class="mt-6 text-sm text-center text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
