<?php

namespace App\Filament\Resources\ToursResource\Pages;

use App\Filament\Resources\ToursResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTours extends CreateRecord
{
    protected static string $resource = ToursResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Buang seoMeta dari $data supaya tidak dikirim ke tabel tours
        unset($data['seoMeta']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $seoData = $this->form->getState()['seoMeta'] ?? [];
        if ($seoData) {
            $this->record->seoMeta()->create($seoData);
        }
    }
}
