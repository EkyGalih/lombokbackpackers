<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum GalleryTypeEnum: string implements HasLabel
{
    case PHOTO = 'Photo';
    case VIDEO = 'Video';

    public function getLabel(): string
    {
        return match ($this) {
            self::PHOTO => 'Photo',
            self::VIDEO => 'Video',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PHOTO => 'primary',
            self::VIDEO => 'success',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }
}
