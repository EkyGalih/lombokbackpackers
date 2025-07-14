<x-filament::widget>
    <x-filament::card>
        <h3 class="text-lg font-bold mb-4">Perbandingan pendapatan</h3>

        <canvas id="bookingPaymentChart"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('bookingPaymentChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($this->labels),
                    datasets: [{
                            label: 'Booking',
                            data: @json($this->bookingData),
                            backgroundColor: '#3b82f6'
                        },
                        {
                            label: 'Pembayaran',
                            data: @json($this->paymentData),
                            backgroundColor: '#10b981'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </x-filament::card>
</x-filament::widget>
