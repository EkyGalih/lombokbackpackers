<?php

namespace App\Models;

use App\Enums\GalleryTypeEnum;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => GalleryTypeEnum::class,
    ];

    public function getUrlAttribute(): string
    {
        return route('galleries.show', $this);
    }

    public function getExcerptAttribute(): string
    {
        $excerpt = strip_tags($this->description);

        return Str::limit($excerpt, 200);
    }

    public function getCustomCreatedAtAttribute(): string
    {
        return $this->created_at->isoFormat('D MMM Y');
    }

    public function images(): BelongsToMany
    {
        return $this
            ->belongsToMany(Media::class, 'media_gallery', 'gallery_id', 'media_id');
    }
}
