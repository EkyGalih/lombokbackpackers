<?php

namespace App\Filament\Resources\BookingClickStatsResource\Widgets;

use App\Models\BookingClick;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class BookingClicksStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('All Probability Booking', number_format(BookingClick::sum('click_count')))
                ->description('Probability of booking (all)')
                ->descriptionIcon('heroicon-o-cursor-arrow-ripple')
                ->color('success'),

            Card::make('Probability Today', number_format(
                BookingClick::whereDate('updated_at', now())->sum('click_count')
            ))
                ->description('Probability booking today')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary'),

            Card::make('Unique User (IP)', BookingClick::distinct('ip_address')->count('ip_address'))
                ->description('Probability of unique users booking today')
                ->descriptionIcon('heroicon-o-users')
                ->color('warning'),
        ];
    }
}
