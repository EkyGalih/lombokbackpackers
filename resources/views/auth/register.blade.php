<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input id="name" class="mt-1 w-full rounded border-gray-300 shadow-sm" type="text" name="name"
                required autofocus />
            @error('name')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" class="mt-1 w-full rounded border-gray-300 shadow-sm" type="email" name="email"
                required />
            @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" class="mt-1 w-full rounded border-gray-300 shadow-sm" type="password" name="password"
                required />
            @error('password')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                Password</label>
            <input id="password_confirmation" class="mt-1 w-full rounded border-gray-300 shadow-sm" type="password"
                name="password_confirmation" required />
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
            Daftar
        </button>

        <p class="mt-6 text-sm text-center text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
