<?php

namespace App\Filament\Resources\PostsResource\Pages;

use App\Filament\Resources\PostsResource;
use App\Traits\HasPreview;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPosts extends EditRecord
{

    use HasPreview;

    protected static string $resource = PostsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->url(fn() => route('blog.show', [
                    'blog' => $this->record->slug,
                    'previewToken' => $this->generatePreviewSession(),
                ]))
                ->openUrlInNewTab(),

            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // ambil media yang sudah dipilih, isi ke form
        $data['media'] = $this->record->media()->pluck('media.id')->toArray();

        if ($this->record->seoMeta) {
            $data['seoMeta'] = $this->record->seoMeta->toArray();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->mediaIds = $data['media'] ?? [];
        $data['excerpt'] = str(strip_tags($data['content']))->limit(100);
        unset($data['media']);

        unset($data['seoMeta']); // Buang seoMeta dari $data supaya tidak dikirim ke tabel posts
        // if (isset($data['tags']) && is_array($data['tags'])) {
        //     $data['tags'] = implode(',', $data['tags']);
        // }

        return $data;
    }

    protected function afterSave(): void
    {
        // sync media
        if (!empty($this->mediaIds)) {
            $this->record->media()->sync($this->mediaIds);
        }

        // update or create seoMeta
        $seoData = $this->form->getState()['seoMeta'] ?? [];
        if ($seoData) {
            $this->record->seoMeta()->updateOrCreate([], $seoData);
        }
    }
}
