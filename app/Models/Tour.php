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
        'summary' => 'array'
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
        'summary'
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

            $tour->generateSummary();

            static::updating(function ($tour) {
                $tour->generateSummary();
            });
        });
    }

    /**
     * Helper untuk mengambil nilai terjemahan dari attribute.
     */
    public function getTranslatedValue(string $attribute, ?string $locale = null): ?string
    {
        $locale = $locale ?: app()->getLocale();

        $value = $this->{$attribute};

        if (is_array($value)) {
            return $value[$locale] ?? null;
        }

        return $value;
    }

public function generateSummary()
    {
        $locale = app()->getLocale();

        $parts = [
            $this->getTranslatedValue('description', $locale),
            $this->getTranslatedValue('notes', $locale),
            $this->getTranslatedValue('itinerary', $locale),
            $this->getTranslatedValue('include', $locale),
            $this->getTranslatedValue('exclude', $locale),
        ];

        $summary = collect($parts)
            ->filter()
            ->implode("\n\n");

        $this->summary = [
            $locale => Str::limit(strip_tags($summary), 200),
        ];
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
