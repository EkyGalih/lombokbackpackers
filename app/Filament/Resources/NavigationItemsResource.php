<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationItemsResource\Pages;
use App\Filament\Resources\NavigationItemsResource\RelationManagers;
use App\Models\NavigationItems;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NavigationItemsResource extends Resource
{
    protected static ?string $model = NavigationItems::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('url')->required(),
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Item')
                    ->options(fn($record) => NavigationItem::where('navigations_id', $record->navigations_id ?? null)
                        ->pluck('title', 'id'))
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
             ->query(fn (Builder $query) => $query->defaultOrder())
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('url'),
            ])
            ->reorderable('order')
            ->defaultSort('lft')
            ->paginated(false)
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
            'index' => Pages\ListNavigationItems::route('/'),
            'create' => Pages\CreateNavigationItems::route('/create'),
            'edit' => Pages\EditNavigationItems::route('/{record}/edit'),
        ];
    }
}
