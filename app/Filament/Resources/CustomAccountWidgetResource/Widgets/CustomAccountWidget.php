<?php

namespace App\Filament\Resources\CustomAccountWidgetResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class CustomAccountWidget extends Widget
{
    protected static string $view = 'filament.resources.custom-account-widget-resource.widgets.custom-account-widget';

    public static function getColumns(): int
    {
        return 3; // adjust grid if needed
    }

    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }
}
