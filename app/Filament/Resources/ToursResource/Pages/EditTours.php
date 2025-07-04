<?php

namespace App\Filament\Resources\ToursResource\Pages;

use App\Filament\Resources\ToursResource;
use Filament\Resources\Pages\EditRecord;

class EditTours extends EditRecord
{
    protected static string $resource = ToursResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data = parent::mutateFormDataBeforeFill($data);

        if ($this->record->seoMeta) {
            $data['seoMeta'] = $this->record->seoMeta->toArray();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Buang seoMeta supaya tidak dikirim ke tabel tours
        unset($data['seoMeta']);
        return $data;
    }

    protected function afterSave(): void
    {
        $seoData = $this->form->getState()['seoMeta'] ?? [];
        if ($seoData) {
            $this->record->seoMeta()->updateOrCreate([], $seoData);
        }
    }
}
