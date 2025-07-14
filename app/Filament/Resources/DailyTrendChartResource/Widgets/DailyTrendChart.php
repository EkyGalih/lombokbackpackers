<?php

namespace App\Filament\Resources\DailyTrendChartResource\Widgets;

use App\Models\Booking;
use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class DailyTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Trend Harian Booking & Pembayaran (Minggu Ini)';

    protected function getData(): array
    {
        $startOfWeek = now()->startOfWeek();
        $labels = [];
        $bookingData = [];
        $paymentData = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $labels[] = $date->translatedFormat('l'); // Senin, Selasa, dst

            $bookingData[] = Booking::whereDate('created_at', $date)->count();

            $paymentData[] = round(
                Payment::whereDate('created_at', $date)->sum('amount') / 1_000_000,
                2
            );
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Booking',
                    'data' => $bookingData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'transparent',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Pembayaran (juta)',
                    'data' => $paymentData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'transparent',
                    'tension' => 0.4,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function canView(): bool
    {
        return true;
    }

    public static function getColumns(): int
    {
        return 12;
    }
}
