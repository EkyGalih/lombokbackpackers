<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaGalerry extends Model
{
    use HasFactory;
    protected $table = 'media_gallery';
    public $guarded = [];
    public $timestamps = false;
}
