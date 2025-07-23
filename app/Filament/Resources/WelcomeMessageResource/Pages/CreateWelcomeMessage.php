<?php

namespace App\Filament\Resources\WelcomeMessageResource\Pages;

use App\Filament\Resources\WelcomeMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWelcomeMessage extends CreateRecord
{
    protected static string $resource = WelcomeMessageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
