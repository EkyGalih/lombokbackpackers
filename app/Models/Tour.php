<?php

namespace App\Models;

use App\Traits\HasUuid;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Tour extends Model
{
    use HasFactory, HasUuid, HasTranslations;

    protected $guarded = [];

    protected $casts = [
        'duration' => 'array',
        'description' => 'array',
        'notes' => 'array',
        'include' => 'array',
        'exclude' => 'array',
        'itinerary' => 'array',
        'slug' => 'string',
        'packet' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seoMeta()
    {
        return $this->morphOne(\App\Models\SeoMeta::class, 'seoable');
    }

    public function ratings()
    {
        return $this->hasMany(Ratings::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($tour) {
            $tour->slug = Str::slug($tour->title) . '-' . Str::random(5);
        });
    }

    public function media()
    {
        return $this->morphToMany(Media::class, 'model', 'media_relationships');
    }
}
