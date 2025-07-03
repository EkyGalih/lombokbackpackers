<?php

namespace App\Filament\Pages;

use App\Settings\WebsiteSettings as WebsiteSettingsModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class WebsiteSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = WebsiteSettingsModel::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $title = 'Website Settings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('site_name')
                    ->label('Site Name')
                    ->required(),

                Forms\Components\FileUpload::make('site_logo')
                    ->label('Site Logo')
                    ->image()
                    ->directory('settings/logos'),

                Forms\Components\FileUpload::make('favicon')
                    ->label('Favicon')
                    ->image()
                    ->directory('settings/favicons'),

                Forms\Components\FileUpload::make('header_image')
                    ->label('Header Image')
                    ->image()
                    ->directory('settings/headers'),

                Forms\Components\TextInput::make('contact_email')
                    ->label('Contact Email')
                    ->email(),

                Forms\Components\TextInput::make('contact_phone')
                    ->label('Contact Phone'),

                Forms\Components\Textarea::make('contact_address')
                    ->label('Contact Address'),
            ]);
    }
}
