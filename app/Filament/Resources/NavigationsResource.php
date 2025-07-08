<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationsResource\Pages;
use App\Models\Navigations;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class NavigationsResource extends Resource
{
    protected static ?string $model = Navigations::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->translatable()
                    ->maxLength(255),
                TextInput::make('handle')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('url')
                    ->maxLength(255),

                Select::make('parent_id')
                    ->label('Parent')
                    ->options(Navigations::pluck('name', 'id'))
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->formatStateUsing(fn ($state, $record) => str_repeat('— ', $record->depth) . $state),

                TextColumn::make('handle'),
                TextColumn::make('url'),
            ])
            ->defaultSort('order')
            ->paginated(false)
            ->recordAction(null)
            ->reorderable('order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigations::route('/'),
            'create' => Pages\CreateNavigations::route('/create'),
            'edit' => Pages\EditNavigations::route('/{record}/edit'),
        ];
    }
}
