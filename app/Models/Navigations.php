<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navigations extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(NavigationItems::class)->whereIsRoot()->defaultOrder();
    }
}
