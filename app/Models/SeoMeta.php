<?php

namespace App\Models;

use App\Traits\AutoTranslateOnSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class SeoMeta extends Model
{
    use HasTranslations, AutoTranslateOnSave;

    protected $guarded = [];
    public $translatable = [
        'meta_title',
        'meta_description',
        'keywords',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = Str::uuid();
            }
        });
    }


    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
