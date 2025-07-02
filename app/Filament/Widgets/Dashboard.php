<?php

namespace App\Filament\Widgets;

use App\Models\Tour;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            Stat::make('Total User', User::count()),
            Stat::make('Total Tour', Tour::count()),
            Stat::make('Total Booking', Booking::count()),
            Stat::make('Total Pembayaran', 'Rp ' . number_format(Payment::sum('amount'), 0, ',', '.')),
        ];
    }
}
