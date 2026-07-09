<?php

namespace App\Filament\Resources\ToursResource\Pages;

use App\Filament\Resources\ToursResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListTours extends ListRecords
{
    use Translatable;

    protected static string $resource = ToursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
