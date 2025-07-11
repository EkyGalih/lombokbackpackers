<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-teal-100 via-cyan-200 to-indigo-100 px-4 py-6">
        <div
            class="bg-white rounded-lg shadow-lg overflow-hidden max-w-2xl w-full flex flex-col md:flex-row animate-fade-in">
            {{-- Ilustrasi --}}
            <div class="hidden md:block md:w-1/2 bg-cover bg-center"
                style="background-image: url('{{ asset('images/travel-illustration.jpg') }}');">
                {{-- Optional: fallback if image is missing --}}
                <img src="{{ asset('images/travel-illustration.jpg') }}" alt="Travel"
                    class="w-full h-full object-cover md:hidden">
            </div>

            {{-- Content --}}
            <div class="w-full md:w-1/2 p-8">
                <h1 class="text-2xl font-bold text-teal-700 mb-4 text-center">
                    Verifikasi Email Anda
                </h1>

                <p class="text-gray-700 text-center mb-4">
                    Terima kasih telah mendaftar di <span class="font-semibold">{{ config('app.name') }}</span>!
                </p>

                <p class="text-gray-600 text-sm text-center mb-6">
                    Silakan periksa email Anda dan klik tautan verifikasi. Jika belum menerima email, kirim ulang dengan
                    tombol di bawah.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm text-center"
                        role="alert">
                        Link verifikasi baru telah dikirim ke email Anda.
                    </div>
                @endif

                <div class="flex flex-col gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded shadow transition">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded shadow transition">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }
    </style>
</x-guest-layout>
