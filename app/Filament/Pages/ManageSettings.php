<?php

namespace App\Filament\Pages;

use App\Settings\WebsiteSettings;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = WebsiteSettings::class;
    protected static ?string $navigationGroup = 'Settings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('site_name')
                    ->label('Site Name')
                    ->required(),

                TextInput::make('header_title')
                    ->label('Header Title'),

                TextInput::make('header_sub_title')
                    ->label('Header Caption'),

                TextInput::make('contact_email')
                    ->label('Contact Email')
                    ->email(),

                TextInput::make('contact_phone')
                    ->label('Contact Phone'),

                TextInput::make('contact_address')
                    ->label('Contact Address'),

                FileUpload::make('site_logo')
                    ->label('Site Logo')
                    ->image()
                    ->directory('settings/logos'),

                FileUpload::make('favicon')
                    ->label('Favicon')
                    ->image()
                    ->directory('settings/favicons'),

                FileUpload::make('header_image')
                    ->label('Header Image')
                    ->image()
                    ->directory('settings/headers'),
            ]);
    }
}
