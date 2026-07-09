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
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;

class CategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('Categories');
    }

    public static function getModelLabel(): string
    {
        return __('Category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Categories');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)
                ->schema([
                    TextInput::make('name')
                        ->columnSpan(8)
                        ->required()
                        ->live(onBlur: false),
                    TextInput::make('order')
                        ->label(__('Priority'))
                        ->columnSpan(4)
                        ->numeric()
                        ->default(fn() => (Category::max('order') ?? 0) + 1),
                ]),
            RichEditor::make('overview')
                ->label(__('Description'))
                ->live(onBlur: false)
                ->columnSpanFull(),
            RichEditor::make('description')
                ->label(__('Content'))
                ->columnSpanFull()
                ->live(onBlur: false),
            Grid::make(12)
                ->schema([
                    CuratorPicker::make('media')
                        ->label(__('Thumbnail'))
                        ->preserveFilenames()
                        ->acceptedFileTypes(['image/*'])
                        ->columnSpan(6)
                        ->multiple(),
                    Toggle::make('show_to_home')
                        ->label(__('Show To Home?'))
                        ->inline(false)
                        ->columnSpan(6)
                        ->onColor('success')
                        ->offColor('danger')
                        ->onIcon('heroicon-m-check')
                        ->offIcon('heroicon-m-x-mark')
                        ->required(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media.0.path')
                    ->label(__('Thumbnail'))
                    ->disk('public')
                    ->size(56),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('show_to_home')
                    ->label(__('Show To Home'))
                    ->badge()
                    ->colors([
                        'false' => 'secondary',
                        'true' => 'success',
                    ])
                    ->formatStateUsing(fn($state) => $state ? __('Yes') : __('No')),
                Tables\Columns\TextColumn::make('order')
                    ->label(__('Priority')),
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
        return parent::getEloquentQuery()->with('media')->orderBy('order');
    }
}
