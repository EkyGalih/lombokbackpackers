<?php

namespace App\Filament\Resources\WelcomeMessageResource\Pages;

use App\Filament\Resources\WelcomeMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWelcomeMessage extends CreateRecord
{
    protected static string $resource = WelcomeMessageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // simpan media_id terpisah
        $this->mediaIds = $data['media'] ?? [];
        unset($data['media']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->mediaIds)) {
            $this->record->media()->sync($this->mediaIds);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
