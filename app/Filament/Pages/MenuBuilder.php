<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MenuBuilder extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
    protected static string $view = 'filament.pages.menu-builder';
    protected static ?string $title = 'Menu Builder';
    protected static ?int $navigationSort = 2;
}
