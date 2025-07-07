<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToursResource\Pages;
use App\Models\Tour;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ToursResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Paket Tour';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make()
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Description')->schema([
                        Hidden::make('user_id')->default(auth()->id()),
                        TextInput::make('title')->required(),
                        Textarea::make('description')->rows(2)->label('Deskripsi'),
                        Grid::make(12)->schema([
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->required()->label('Kategori')
                                ->columnSpan(6),

                            TextInput::make('price')
                                ->numeric()->required()->prefix('Rp')
                                ->columnSpan(3),

                            TextInput::make('package_person_count')
                                ->numeric()->required()->label('Per Person')
                                ->columnSpan(3),
                        ]),
                        TextInput::make('duration')->numeric()->required()->label('Durasi (hari)'),
                        Grid::make(12)->schema([
                            TextInput::make('discount')
                                ->numeric()->prefix('Rp')->label('Diskon')
                                ->columnSpan(4),
                            DatePicker::make('discount_start')
                                ->label('Start')->columnSpan(4),
                            DatePicker::make('discount_end')
                                ->label('End')->columnSpan(4),
                        ]),
                        CuratorPicker::make('media')
                            ->label('Thumbnail')
                            ->relationship('media', 'id')
                            ->multiple()
                    ]),
                    Tab::make('SEO')->schema([
                        TextInput::make('seoMeta.meta_title')->label('Meta Title'),
                        Textarea::make('seoMeta.meta_description')->label('Meta Description'),
                        TextInput::make('seoMeta.keywords')->label('Keywords'),
                        TextInput::make('seoMeta.canonical_url')->label('Canonical URL'),
                        TextInput::make('seoMeta.robots')->label('Robots')->default('index, follow'),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('media.0.path')
                ->label('Thumbnail')
                ->disk('public')
                ->size(60),
            Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('category.name')->label('Kategori')->sortable(),
            Tables\Columns\TextColumn::make('price')->money('IDR', true),
            Tables\Columns\TextColumn::make('duration')->label('Durasi (hari)'),
            Tables\Columns\TextColumn::make('seoMeta.meta_title')->label('SEO Title'),
        ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTours::route('/create'),
            'edit' => Pages\EditTours::route('/{record}/edit'),
        ];
    }
}
