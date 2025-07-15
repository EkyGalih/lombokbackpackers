<?php

namespace App\Filament\Resources\ToursResource\Pages;

use App\Filament\Resources\ToursResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditTours extends EditRecord
{
    protected static string $resource = ToursResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data = parent::mutateFormDataBeforeFill($data);

        if ($this->record->seoMeta) {
            $data['seoMeta'] = $this->record->seoMeta->toArray();
        }

        $data['category_name'] = $this->record->category?->name ?? '';

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['seoMeta']); // optional kalau pakai relasi

        $category = \App\Models\Category::whereRaw(
            'LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.id"))) = ?',
            [strtolower($data['category_name'])]
        )->first();

        if (! $category) {
            $category = \App\Models\Category::create([
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'name' => [
                    'en' => $data['category_name'],
                    'id' => $data['category_name'],
                ],
                'slug' => Str::slug($data['category_name']),
            ]);
        }

        $data['category_id'] = $category->id;

        unset($data['category_name']);

        return $data;
    }

    protected function afterSave(): void
    {
        $seoData = $this->form->getState()['seoMeta'] ?? [];
        if ($seoData) {
            $this->record->seoMeta()->updateOrCreate([], $seoData);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
