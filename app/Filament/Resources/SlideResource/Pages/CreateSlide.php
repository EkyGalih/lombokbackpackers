<?php

namespace App\Filament\Resources\SlideResource\Pages;

use App\Filament\Resources\SlideResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateSlide extends CreateRecord
{
    use Translatable;

    protected static string $resource = SlideResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Save media_id separately
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
