<?php

namespace App\Filament\Resources\TourCompositionChartResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class TourCompositionChart extends ChartWidget
{
    protected static ?string $heading = 'Paket Paling Banyak Dipesan';

    protected function getData(): array
    {
        $popular = Booking::whereHas('tour')
            ->selectRaw('tour_id, COUNT(*) as total')
            ->groupBy('tour_id')
            ->orderByDesc('total')
            ->with('tour')
            ->get();

        $labels = $popular->map(fn($b) => $b->tour->title ?? 'Unknown')->toArray();
        $data = $popular->map(fn($b) => $b->total)->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Booking',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                        '#ec4899',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public static function canView(): bool
    {
        return true; // Atur permission jika mau
    }
}
