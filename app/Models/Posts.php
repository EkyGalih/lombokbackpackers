<?php

namespace App\Models;

use App\Traits\AutoTranslateOnSave;
use App\Traits\HasUuid;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Posts extends Model
{
    use HasFactory, HasUuid, HasTranslations, AutoTranslateOnSave;

    protected $guarded = [];
    protected $casts = [
        'tags' => 'array',
    ];
    protected $translatable = [
        'title',
        'excerpt',
        'content',
    ];

    protected static function booted(): void
    {
        static::creating(function ($tour) {
            // slug hanya pakai locale default
            $currentLocale = app()->getLocale();
            $title = $tour->title;

            // kalau title translatable, ambil default locale value
            if (is_array($title) && isset($title[$currentLocale])) {
                $titleForSlug = $title[$currentLocale];
            } else {
                $titleForSlug = $title;
            }

            $tour->slug = Str::slug($titleForSlug);
        });
    }

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function media()
    {
        return $this->morphToMany(Media::class, 'model', 'media_relationships');
    }
}
