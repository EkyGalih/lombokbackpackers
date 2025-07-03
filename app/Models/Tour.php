<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    protected static function booted(): void
    {
        static::creating(function ($tour) {
            $tour->slug = Str::slug($tour->title) . '-' . Str::random(5);
        });
    }
}
