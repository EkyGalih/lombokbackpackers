<?php

namespace App\Models;

use App\Traits\AutoTranslateOnSave;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Navigations extends Model
{
    use HasFactory, HasTranslations, AutoTranslateOnSave;
    protected $guarded = [];
    protected $translatable = ['name'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }

    public function getDepthAttribute(): int
    {
        $depth = 0;
        $parent = $this->parent;
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }
        return $depth;
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public static function booted()
    {
        static::addGlobalScope('withParent', function ($query) {
            $query->with('parent');
        });
    }
}
