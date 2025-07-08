<?php

namespace App\Filament\Resources\NavigationItemsResource\Pages;

use App\Filament\Resources\NavigationItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNavigationItems extends EditRecord
{
    protected static string $resource = NavigationItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
