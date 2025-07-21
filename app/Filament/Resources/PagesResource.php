<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PagesResource\Pages;
use App\Filament\Resources\PagesResource\RelationManagers;
use App\Models\Pages as ModelPages;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PagesResource extends Resource
{
    protected static ?string $model = ModelPages::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationLabel = 'Pages';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General')->schema([
                            Grid::make(12)
                                ->schema([
                                    TextInput::make('title')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->formatStateUsing(function ($state) {
                                            if (is_array($state)) {
                                                return $state[app()->getLocale()] ?? '';
                                            }
                                            return $state;
                                        })
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            // Kalau SEO title masih kosong
                                            $set('seoMeta.meta_title', $state);
                                            // Kalau slug masih kosong
                                            $set('slug', str($state)->slug());
                                            // set url seo
                                            $set('seoMeta.canonical_url', url(ENV('APP_URL') . '/page/' . str($state)->slug()));
                                        })
                                        ->columnSpan(6),
                                    TextInput::make('slug')
                                        ->readonly()
                                        ->formatStateUsing(function ($state) {
                                            if (is_array($state)) {
                                                return $state[app()->getLocale()] ?? '';
                                            }
                                            return $state;
                                        })
                                        ->columnSpan(6)
                                        ->required()
                                        ->unique(ignoreRecord: true),
                                ]),
                            RichEditor::make('content')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                })
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $plainText = strip_tags($state);

                                    $seoDesc = str($plainText)->limit(160);

                                    // ambil kata2
                                    $words = str($plainText)
                                        ->lower()
                                        ->explode(' ')
                                        ->map(fn($word) => trim(preg_replace('/[^a-z0-9]/', '', $word)))
                                        ->filter(fn($word) => strlen($word) > 3) // minimal panjang kata
                                        ->unique()
                                        ->take(10)
                                        ->implode(', ');

                                    $set('seoMeta.meta_description', $seoDesc);
                                    $set('seoMeta.keywords', $words);
                                })
                                ->required(),

                            Grid::make(12)
                                ->schema([
                                    Grid::make(12)
                                        ->schema([
                                            CuratorPicker::make('media')
                                                ->label('Thumbnail')
                                                ->multiple()
                                                ->nullable()
                                                ->columnSpan(12),
                                        ]),
                                ]),
                        ]),
                        Tab::make('SEO')->schema([
                            TextInput::make('seoMeta.meta_title')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                })
                                ->label('Meta Title'),
                            Textarea::make('seoMeta.meta_description')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                })
                                ->label('Meta Description'),
                            TextInput::make('seoMeta.keywords')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                })
                                ->label('Keywords'),
                            TextInput::make('seoMeta.canonical_url')->label('Canonical URL'),
                            TextInput::make('seoMeta.robots')->label('Robots')->default('index, follow'),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media.0.path')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->size(50),
                TextColumn::make('title')->searchable(),
                TextColumn::make('slug')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePages::route('/create'),
            'edit' => Pages\EditPages::route('/{record}/edit'),
        ];
    }
}
