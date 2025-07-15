<?php

namespace App\Filament\Resources\ToursResource\Pages;

use App\Filament\Resources\ToursResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTours extends CreateRecord
{
    protected static string $resource = ToursResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['seoMeta']); // Buang seoMeta

        // Cari kategori dengan name->id sama (case-insensitive)
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

    protected function afterCreate(): void
    {
        $seoData = $this->form->getState()['seoMeta'] ?? [];
        if ($seoData) {
            $this->record->seoMeta()->create($seoData);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
