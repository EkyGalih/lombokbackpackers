<?php

namespace App\Filament\Resources\NavigationsResource\Pages;

use App\Filament\Resources\NavigationsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNavigations extends ListRecords
{
    protected static string $resource = NavigationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
