<?php

namespace App\Filament\Resources\NavigationsResource\Pages;

use App\Filament\Resources\NavigationsResource;
use App\Models\Navigations;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListNavigations extends ListRecords
{
    protected static string $resource = NavigationsResource::class;

    protected $listeners = ['saveTree'];

    public function saveTree(array $tree): void
    {
        $this->updateTree($tree, null);

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    private function updateTree(array $items, ?int $parentId): void
    {
        foreach ($items as $index => $item) {
            Navigations::whereKey($item['id'])->update([
                'parent_id' => $parentId,
                'order' => $index + 1,
            ]);

            if (!empty($item['children'])) {
                $this->updateTree($item['children'], $item['id']);
            }
        }
    }
}
