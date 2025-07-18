<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureResource\Pages;
use App\Models\Features;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeatureResource extends Resource
{
    protected static ?string $model = Features::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationLabel = 'Features';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->columnSpanFull()
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return $state[app()->getLocale()] ?? '';
                        }
                        return $state;
                    })
                    ->required(),
                Grid::make(12)
                    ->schema([
                        RichEditor::make('description')
                            ->formatStateUsing(function ($state) {
                                if (is_array($state)) {
                                    return $state[app()->getLocale()] ?? '';
                                }
                                return $state;
                            })
                            ->columnSpan(6)
                            ->label('Description'),
                        CuratorPicker::make('media')
                            ->label('Thumbnail')
                            ->columnSpan(6)
                            ->multiple()
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media.0.path')
                    ->label('Thumbnail')
                    ->circular()
                    ->size(50)
                    ->default('https://via.placeholder.com/50'),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->html()
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListFeatures::route('/'),
            // 'create' => Pages\CreateFeature::route('/create'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}
