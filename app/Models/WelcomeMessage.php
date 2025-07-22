<?php

namespace App\Models;

use App\Traits\AutoTranslateOnSave;
use App\Traits\HasUuid;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class WelcomeMessage extends Model
{
    use HasFactory, HasUuid, HasTranslations, AutoTranslateOnSave;

    protected $guarded = [];
    protected $translatable = ['title', 'description'];
}
