<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToursResource\Pages;
use App\Filament\Resources\ToursResource\RelationManagers;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
            Tabs::make('Tabs')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Tour')
                        ->schema([
                            Hidden::make('user_id')->default(auth()->id()),
                            TextInput::make('title')->required(),
                            Textarea::make('description')->rows(2)->label('Deskripsi'),
                            Grid::make(12)
                                ->schema([
                                    Select::make('category_id')
                                        ->relationship('category', 'name')
                                        ->label('Kategori')
                                        ->required()
                                        ->columnSpan(6), // Lebar 6/12

                                    TextInput::make('price')
                                        ->numeric()
                                        ->required()
                                        ->prefix('Rp')
                                        ->columnSpan(3), // Lebar 3/12

                                    TextInput::make('package_person_count')
                                        ->numeric()
                                        ->required()
                                        ->columnSpan(3)
                                        ->label('Per Person'), // Lebar 3/12
                                ]),
                            TextInput::make('duration')->numeric()->label('Durasi (hari)')->required(),
                            Grid::make(12)->schema([
                                TextInput::make('discount')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->label('Diskon (Rp)')
                                    ->columnSpan(4),
                                DatePicker::make('discount_start')
                                    ->label('Start Discount')
                                    ->columnSpan(4),

                                DatePicker::make('discount_end')
                                    ->label('End Discount')
                                    ->columnSpan(4),
                            ]),
                            FileUpload::make('thumbnail')
                                ->image()
                                ->directory('tours')
                                ->label('Gambar'),
                        ]),
                    Tab::make('SEO')
                        ->schema([
                            TextInput::make('seoMeta.meta_title')
                                ->label('Meta Title')
                                ->required(),
                            Textarea::make('seoMeta.meta_description')
                                ->label('Meta Description'),
                            TextInput::make('seoMeta.keywords')
                                ->label('Keywords'),
                            TextInput::make('seoMeta.canonical_url')
                                ->label('Canonical URL'),
                            TextInput::make('seoMeta.robots')
                                ->default('index, follow'),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->size(60),
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->sortable(),
                Tables\Columns\TextColumn::make('price')->money('IDR', true),
                Tables\Columns\BadgeColumn::make('package_person_count')
                    ->label('Jumlah Orang')
                    ->colors([
                        'success' => fn($state) => $state <= 2,
                        'warning' => fn($state) => $state > 2 && $state <= 5,
                        'danger' => fn($state) => $state > 5,
                    ])
                    ->formatStateUsing(fn($state) => "{$state} org")
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')->label('Durasi (hari)'),
                Tables\Columns\TextColumn::make('seoMeta.meta_title')
                    ->label('SEO Title')
                    ->searchable(),
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

    public static function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['seoMeta'])) {
            $seoData = $data['seoMeta'];
            unset($data['seoMeta']);
            request()->merge(['seoMeta' => $seoData]);
        }
        return $data;
    }

    public static function afterSave($record, array $data): void
    {
        if (isset($data['seoMeta'])) {
            $record->seoMeta()->updateOrCreate([], $data['seoMeta']);
        }
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
