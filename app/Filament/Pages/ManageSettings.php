<?php

namespace App\Filament\Pages;

use App\Settings\WebsiteSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
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
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->required(),

                                TextInput::make('header_title')
                                    ->label('Header Title'),

                                TextInput::make('header_sub_title')
                                    ->label('Header Caption'),

                                Textarea::make('maps')
                                    ->label('Maps')
                                    ->rows(4)
                                    ->columnSpanFull(),

                                Grid::make(12)
                                    ->schema([
                                        TextInput::make('contact_email')
                                            ->label('Contact Email')
                                            ->columnSpan(6)
                                            ->email(),

                                        TextInput::make('contact_phone')
                                            ->columnSpan(6)
                                            ->label('Contact Phone'),
                                    ]),
                                Grid::make(12)
                                    ->schema([
                                        RichEditor::make('contact_address')
                                            ->columnSpan(6)
                                            ->label('Address'),

                                        FileUpload::make('site_logo')
                                            ->label('Site Logo')
                                            ->image()
                                            ->columnSpan(6)
                                            ->directory('settings/logos'),
                                    ]),
                                Grid::make(12)
                                    ->schema([
                                        FileUpload::make('favicon')
                                            ->label('Favicon')
                                            ->image()
                                            ->columnSpan(6)
                                            ->directory('settings/favicons'),

                                        FileUpload::make('header_image')
                                            ->label('Header Image')
                                            ->image()
                                            ->columnSpan(6)
                                            ->directory('settings/headers'),
                                    ])
                            ]),
                        Tab::make('Social Media')
                            ->schema([
                                TextInput::make('social_facebook')
                                    ->label('Facebook'),
                                TextInput::make('social_instagram')
                                    ->label('Instagram'),
                                TextInput::make('social_x')
                                    ->label('X'),
                                TextInput::make('social_youtube')
                                    ->label('YouTube'),
                            ])
                    ])
            ]);
    }
}
