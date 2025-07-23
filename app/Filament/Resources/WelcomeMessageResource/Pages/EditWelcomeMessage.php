<?php

namespace App\Filament\Resources\WelcomeMessageResource\Pages;

use App\Filament\Resources\WelcomeMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWelcomeMessage extends EditRecord
{
    protected static string $resource = WelcomeMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
