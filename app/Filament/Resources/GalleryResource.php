<?php

namespace App\Filament\Resources;

use App\Enums\GalleryTypeEnum;
use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Menu';

    protected static ?string $navigationLabel = 'Gallery';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->placeholder('Enter a name')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, string $operation, ?string $old, ?string $state) {
                                if (($get('slug') ?? '') !== Str::slug($old) || $operation !== 'create') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            })
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        Forms\Components\TextInput::make('slug')
                            ->placeholder('Enter a slug')
                            ->alphaDash()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('type')
                            ->label('Select gallery type')
                            ->options(GalleryTypeEnum::class)
                            ->live()
                            ->disabledOn('edit')
                            ->required(),

                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),

                        CuratorPicker::make('images')
                            ->label('Upload images')
                            ->preserveFilenames()
                            ->acceptedFileTypes(['image/*'])
                            ->multiple()
                            ->maxSize(15360)
                            ->relationship('images', 'id')
                            ->columnSpanFull()
                            ->live()
                            ->visible(fn(\Filament\Forms\Get $get): bool => $get('type') === 'Photo'),

                        Forms\Components\TextInput::make('link_video')
                            ->label('Link video youtube')
                            ->columnSpanFull()
                            ->url()
                            ->suffixIcon('heroicon-m-globe-alt')
                            ->required()
                            ->visible(fn(\Filament\Forms\Get $get): bool => $get('type') === 'Video'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->html(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Gallery type')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        GalleryTypeEnum::PHOTO => 'gray',
                        GalleryTypeEnum::VIDEO => 'success',
                    }),
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
            'index' => Pages\ListGalleries::route('/'),
            // 'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
