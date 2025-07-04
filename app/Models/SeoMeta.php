<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class SeoMeta extends Model
{
    protected $guarded = [];

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
