<?php

namespace App\Filament\Resources\PostsResource\Pages;

use App\Filament\Resources\PostsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePosts extends CreateRecord
{
    protected static string $resource = PostsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Simpan media_id terpisah
        $this->mediaIds = $data['media'] ?? [];
        $data['excerpt'] = str(strip_tags($data['content']))->limit(100);
        unset($data['media']);
        unset($data['seoMeta']); // Buang seoMeta dari $data supaya tidak dikirim ke tabel posts

        // if (isset($data['tags']) && is_array($data['tags'])) {
        //     $data['tags'] = implode(',', $data['tags']);
        // }
        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->mediaIds)) {
            $this->record->media()->sync($this->mediaIds);
        }

        $seoData = $this->form->getState()['seoMeta'] ?? [];
        if ($seoData) {
            // Simpan seoMeta setelah post dibuat
            $this->record->seoMeta()->create($seoData);
        }
    }
}
