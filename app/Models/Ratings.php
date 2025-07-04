<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ratings extends Model
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

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
