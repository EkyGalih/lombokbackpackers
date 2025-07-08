<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class NavigationItems extends Model
{
    use NodeTrait;

    protected $guarded = [];

    public function navigation()
    {
        return $this->belongsTo(Navigations::class);
    }
}
