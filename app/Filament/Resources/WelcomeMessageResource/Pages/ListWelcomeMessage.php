<?php

namespace App\Filament\Resources\WelcomeMessageResource\Pages;

use App\Filament\Resources\WelcomeMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWelcomeMessage extends ListRecords
{
    protected static string $resource = WelcomeMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
