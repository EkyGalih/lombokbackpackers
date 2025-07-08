<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasUuid, HasTranslations;

    protected $guarded = [];
    public $translatable = ['name'];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
