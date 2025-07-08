<?php

namespace App\Filament\Resources\NavigationItemsResource\Pages;

use App\Filament\Resources\NavigationItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNavigationItems extends ListRecords
{
    protected static string $resource = NavigationItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
