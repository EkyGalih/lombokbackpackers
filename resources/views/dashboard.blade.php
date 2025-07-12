<x-app-layout>
    <div class="container mx-auto py-10 space-y-8">

        {{-- Judul --}}
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Saya</h2>

        {{-- Statistik Ringkas --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="p-4 bg-white shadow rounded-xl text-center">
                <h3 class="text-sm text-gray-600">Total Booking</h3>
                <p class="text-2xl font-bold text-indigo-600 mt-2">
                    {{ auth()->user()->bookings()->count() }}
                </p>
            </div>

            <div class="p-4 bg-white shadow rounded-xl text-center">
                <h3 class="text-sm text-gray-600">Total Pembayaran</h3>
                <p class="text-2xl font-bold text-green-600 mt-2">
                    Rp {{ number_format(auth()->user()->bookings()->sum('total_price'), 0, ',', '.') }}
                </p>
            </div>

            <div class="p-4 bg-white shadow rounded-xl text-center">
                <h3 class="text-sm text-gray-600">Status Akun</h3>
                <p class="text-lg mt-2">
                    @if (auth()->user()->hasVerifiedEmail())
                        <span class="text-green-600 font-semibold">Terverifikasi</span>
                    @else
                        <span class="text-red-600 font-semibold">Belum Verifikasi</span>
                    @endif
                </p>
            </div>

            <div class="p-4 bg-white shadow rounded-xl text-center">
                <h3 class="text-sm text-gray-600">Tanggal Gabung</h3>
                <p class="text-lg text-gray-700 mt-2">
                    {{ auth()->user()->created_at->format('d M Y') }}
                </p>
            </div>
        </div>

        {{-- Grafik Booking --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4">Statistik Booking Bulanan</h3>
            <canvas id="bookingChart" height="100"></canvas>
        </div>

        {{-- Aktivitas Terbaru & Tips --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Aktivitas Terbaru --}}
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-xl font-bold mb-4">Aktivitas Terbaru</h3>
                <ul class="space-y-2 text-sm">
                    @forelse($recentBookings as $booking)
                        <li>
                            <strong>{{ $booking->tour->title }}</strong> -
                            <span class="capitalize">{{ $booking->status->value }}</span>
                            ({{ $booking->created_at->diffForHumans() }})
                        </li>
                    @empty
                        <li class="text-gray-500">Belum ada aktivitas terbaru.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Tips & Promo --}}
            <div class="bg-indigo-50 p-6 rounded-xl shadow">
                <h3 class="text-lg font-bold text-indigo-700">Tips & Promo</h3>
                <ul class="list-disc ml-5 text-sm text-indigo-700 mt-2 space-y-1">
                    <li>Verifikasi email Anda untuk keamanan lebih baik.</li>
                    <li>Lengkapi profil Anda agar proses booking lebih cepat.</li>
                    <li>Cek promo menarik di halaman <a href="#" class="underline">Promo</a>.</li>
                </ul>
            </div>
        </div>

        {{-- Call to Action --}}
        <div class="bg-green-50 border-l-4 border-green-400 p-6 rounded-xl shadow">
            <h3 class="text-lg font-bold text-green-700">Ayo Booking Lagi!</h3>
            <p class="text-sm text-green-600 mt-1">Jelajahi tour terbaru kami untuk pengalaman yang lebih seru.</p>
            <a href="{{ route('bookings.index') }}"
                class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Lihat Tour</a>
        </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('bookingChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Booking per Bulan',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: 'rgba(79, 70, 229, 0.7)',
                        borderRadius: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
