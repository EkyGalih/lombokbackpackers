<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideResource\Pages;
use App\Models\Slides;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;

class SlideResource extends Resource
{
    use Translatable;

    protected static ?string $model = Slides::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 6;

    public static function getNavigationLabel(): string
    {
        return __('Slides');
    }

    public static function getModelLabel(): string
    {
        return __('Slide');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Slides');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->columnSpanFull(),
                Grid::make(12)
                    ->schema([
                        RichEditor::make('description')
                            ->label(__('Description'))
                            ->columnSpan(6)
                            ->required(),
                        CuratorPicker::make('media')
                            ->label(__('Slide Images'))
                            ->multiple()
                            ->required()
                            ->columnSpan(6)
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media.0.path')
                    ->label(__('Thumbnail'))
                    ->size(100, 100)
                    ->square()
                    ->default('https://via.placeholder.com/100'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('Description'))
                    ->searchable()
                    ->limit(50)
                    ->html()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListSlides::route('/'),
            'create' => Pages\CreateSlide::route('/create'),
            'edit' => Pages\EditSlide::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with('media');
    }
}
