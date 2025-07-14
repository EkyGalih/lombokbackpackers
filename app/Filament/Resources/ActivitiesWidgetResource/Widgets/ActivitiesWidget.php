<?php

namespace App\Filament\Resources\ActivitiesWidgetResource\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ActivitiesWidget extends TableWidget
{
    protected static ?string $heading = 'Booking Terakhir';

    protected function getTableQuery(): Builder
    {
        return Booking::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('iteration')
                ->label('#')
                ->getStateUsing(function ($record, Tables\Columns\Column $column, $rowLoop) {
                    return $rowLoop->iteration;
                }),

            Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Booked At')
                ->dateTime(),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'success' => 'confirmed',
                    'warning' => 'pending',
                    'danger' => 'cancelled',
                ]),
        ];
    }

    public static function getColumns(): int
    {
        return 12;
    }
}
