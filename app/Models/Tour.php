<?php

namespace App\Models;

use App\Traits\AutoTranslateOnSave;
use App\Traits\HasUuid;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Tour extends Model
{
    use HasFactory, HasUuid, HasTranslations, AutoTranslateOnSave;

    protected $guarded = [];

    protected $casts = [
        'description' => 'array',
        'notes' => 'array',
        'include' => 'array',
        'exclude' => 'array',
        'slug' => 'string',
        'duration' => 'array',
        'packet' => 'array',
        'itinerary' => 'array',
    ];

    protected $translatable = [
        'title',
        'description',
        'notes',
        'include',
        'exclude',
        'duration',
        'packet',
        'itinerary',
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
            // slug hanya pakai locale default
            $currentLocale = app()->getLocale();
            $title = $tour->title;

            // kalau title translatable, ambil default locale value
            if (is_array($title) && isset($title[$currentLocale])) {
                $titleForSlug = $title[$currentLocale];
            } else {
                $titleForSlug = $title;
            }

            $tour->slug = Str::slug($titleForSlug) . '-' . Str::random(5);
        });
    }

    public function getPricesAttribute(): array
    {
        $packet = $this->packet;

        if (!is_array($packet)) {
            return [];
        }

        $prices = collect($packet)->map(function ($item) {
            if (!isset($item['value'])) {
                return null;
            }

            // Ambil angka terakhir dari value
            preg_match_all('/\d{1,3}(?:[.,]\d{3})+/', $item['value'], $matches);

            if (!empty($matches[0])) {
                $last = end($matches[0]);
                return (int) str_replace(['.', ','], '', $last);
            }

            return null;
        })->filter();

        return $prices->values()->toArray();
    }


    public function getLowestPriceAttribute(): ?int
    {
        $prices = $this->prices;

        return !empty($prices) ? min($prices) : null;
    }

    public function getHighestPriceAttribute(): ?int
    {
        $prices = $this->prices;

        return !empty($prices) ? max($prices) : null;
    }

    public function media()
    {
        return $this->morphToMany(Media::class, 'model', 'media_relationships');
    }
}
