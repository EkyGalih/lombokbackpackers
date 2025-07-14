<x-filament::widget>
    <x-filament::card>
        <h3 class="text-lg font-bold mb-4">Trend Harian Booking & Pembayaran (Minggu Ini)</h3>

        <canvas id="dailyTrendChart"></canvas>

        <script>
            new Chart(document.getElementById('dailyTrendChart'), {
                type: 'line',
                data: {
                    labels: @json($this->labels),
                    datasets: [
                        {
                            label: 'Booking',
                            data: @json($this->bookingData),
                            borderColor: '#3b82f6',
                            tension: 0.3
                        },
                        {
                            label: 'Pembayaran (juta)',
                            data: @json($this->paymentData),
                            borderColor: '#10b981',
                            tension: 0.3
                        }
                    ]
                }
            });
        </script>
    </x-filament::card>
</x-filament::widget>
