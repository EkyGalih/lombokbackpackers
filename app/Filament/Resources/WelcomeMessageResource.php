<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WelcomeMessageResource\Pages;
use App\Models\WelcomeMessage;
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

class WelcomeMessageResource extends Resource
{
    protected static ?string $model = WelcomeMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Welcome Message';
    protected static ?int $navigationSort = 1;

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
                            ->columnSpan(12)
                            ->label('Description')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListWelcomeMessage::route('/'),
            // 'create' => Pages\CreateWelcomeMessage::route('/create'),
            'edit' => Pages\EditWelcomeMessage::route('/{record}/edit'),
        ];
    }
}
