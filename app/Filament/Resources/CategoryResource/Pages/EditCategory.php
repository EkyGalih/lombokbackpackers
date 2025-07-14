<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // ambil media yang sudah dipilih, isi ke form
        $data['media'] = $this->record->media()->pluck('media.id')->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->mediaIds = $data['media'] ?? [];
        unset($data['media']);

        return $data;
    }

    protected function afterSave(): void
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
