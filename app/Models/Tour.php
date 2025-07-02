<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
