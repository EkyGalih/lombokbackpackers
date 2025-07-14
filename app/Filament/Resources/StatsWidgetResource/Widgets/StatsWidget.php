<?php

namespace App\Filament\Resources\StatsWidgetResource\Widgets;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            $this->statWithAnimation('Total User', User::count()),
            $this->statWithAnimation('Total Tour', Tour::count()),
            $this->statWithAnimation('Total Booking', Booking::count()),
            $this->statWithAnimation(
                'Total Pembayaran',
                Payment::sum('amount'),
                'Rp '
            ),
        ];
    }

    private function statWithAnimation(string $label, int|float $value, string $prefix = ''): Stat
    {
        return Stat::make($label, '')
            ->extraAttributes([
                'x-data' => '{ count: 0 }',
                'x-init' => "
                    let el = \$el.querySelector('.fi-wi-stats-overview-stat-value');
                    let target = {$value};
                    let step = Math.max(1, Math.floor(target / 50));
                    let interval = setInterval(() => {
                        count += step;
                        if (count >= target) {
                            count = target;
                            clearInterval(interval);
                        }
                        el.textContent = '{$prefix}' + count.toLocaleString();
                    }, 20);
                ",
            ])
            ->description($prefix . number_format($value)); // fallback real number in description
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
