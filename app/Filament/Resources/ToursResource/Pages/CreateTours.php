<?php

namespace App\Filament\Resources\ToursResource\Pages;

use App\Filament\Resources\ToursResource;
use App\Models\Category;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTours extends CreateRecord
{
    protected static string $resource = ToursResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['seoMeta']); // Buang seoMeta

        $slug = Str::slug($data['category_name']);

        // cati kategory yang sudah ada berdasarkan slug
        $category = Category::whereRaw('LOWER(slug) = ?', [strtolower($slug)])->first();

        if (!$category) {
            // kalau belum ada, buat slug unik
            $category = Category::create([
                'id' => Str::uuid()->toString(),
                'name' => [
                    'en' => $data['category_name'],
                    'id' => $data['category_name'],
                ],
                'slug' => $slug,
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
