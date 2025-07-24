<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Categories';
    protected static ?string $modelLabel = 'Categories';
    protected static ?string $pluralModelLabel = 'Category';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)
                ->schema([
                    TextInput::make('name')
                        ->columnSpan(8)
                        ->formatStateUsing(function ($state) {
                            if (is_array($state)) {
                                return $state[app()->getLocale()] ?? '';
                            }
                            return $state;
                        })
                        ->required()
                        ->live(onBlur: false),
                    TextInput::make('order')
                        ->label('Order')
                        ->columnSpan(4)
                        ->numeric()
                        ->default(fn() => (Category::max('order') ?? 0) + 1),
                ]),
            Grid::make(12)
                ->schema([
                    RichEditor::make('description')
                        ->columnSpanFull()
                        ->formatStateUsing(function ($state) {
                            if (is_array($state)) {
                                return $state[app()->getLocale()] ?? '';
                            }
                            return $state;
                        })
                        ->columnSpan(6)
                        ->live(onBlur: false),
                    CuratorPicker::make('media')
                        ->label('Thumbnail')
                        ->preserveFilenames()
                        ->acceptedFileTypes(['image/*'])
                        ->columnSpan(6)
                        ->multiple(),
                ]),
            Toggle::make('show_to_home')
                ->label('Show To Home?')
                ->inline(false)
                ->onColor('success')
                ->offColor('danger')
                ->onIcon('heroicon-m-check')
                ->offIcon('heroicon-m-x-mark')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media.0.path')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->size(56),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('show_to_home')
                    ->label('Show To Home')
                    ->badge()
                    ->colors([
                        'false' => 'secondary',
                        'true' => 'success',
                    ])
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
                Tables\Columns\TextColumn::make('order')
                    ->label('Order'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->orderBy('order');
    }
}
