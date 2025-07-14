<?php

namespace App\Filament\Resources\BookingPaymentChartResource\Widgets;

use App\Models\Booking;
use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class BookingPaymentChart extends ChartWidget
{
    protected static ?string $heading = 'Trend Bulan Kemarin vs Bulan Ini';

    protected function getData(): array
    {
        $now = now();
        $lastMonth = now()->subMonthNoOverflow();

        $labels = [
            $lastMonth->locale('id')->translatedFormat('F Y'),
            $now->locale('id')->translatedFormat('F Y'),
        ];

        $bookingData = [
            Booking::whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year)
                ->count(),
            Booking::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->count(),
        ];

        $paymentData = [
            round(Payment::whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year)
                ->sum('amount') / 1_000_000, 2),
            round(Payment::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->sum('amount') / 1_000_000, 2),
        ];

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Booking',
                    'data' => $bookingData,
                    'backgroundColor' => '#3b82f6',
                ],
                [
                    'label' => 'Pembayaran (juta)',
                    'data' => $paymentData,
                    'backgroundColor' => '#10b981',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public static function canView(): bool
    {
        return true;
    }
}
