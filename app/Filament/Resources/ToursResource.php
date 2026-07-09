<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToursResource\Pages;
use App\Models\Category;
use App\Models\Tour;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;

class ToursResource extends Resource
{
    use Translatable;

    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('Tour Packages');
    }

    public static function getModelLabel(): string
    {
        return __('Tour Package');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tour Packages');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make()
                ->columnSpanFull()
                ->tabs([
                    Tab::make('General')->schema([
                        Hidden::make('user_id')->default(auth()->id()),
                        Grid::make(12)->schema([
                            TextInput::make('title')
                                ->label(__('Title'))
                                ->required()
                                ->placeholder('e.g: Traveling with us 4 days, 3 nights to komodo island')
                                ->live(onBlur: true)
                                ->columnSpan(6)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    // kalau seo title masih kosong
                                    $set('seoMeta.meta_title', $state);
                                    // set rul seo
                                    $set('seoMeta.canonical_url', url(ENV('APP_URL') . '/tours/' . str($state)->slug()));
                                }),
                            TextInput::make('duration')->required()->label(__('Duration (days and nights)'))
                                ->placeholder('e.g., 3 days 2 nights')
                                ->columnSpan(6),
                        ]),
                        Grid::make(12)->schema([
                            TextInput::make('category_name')
                                ->label(__('Category'))
                                ->placeholder('ambil berdasarkan category yang sudah ada atau buat baru')
                                ->datalist(
                                    Category::pluck('name')->toArray()
                                )
                                ->required()
                                ->columnSpan(8)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    // cari category_id berdasarkan nama
                                    $category = \App\Models\Category::where('name->' . app()->getLocale(), $state)->first();

                                    if ($category) {
                                        // cari order terakhir pada tour untuk kategori tersebut
                                        $lastOrder = \App\Models\Tour::where('category_id', $category->id)->max('order') ?? 0;

                                        // isi field order dengan nilai berikutnya
                                        $set('order', $lastOrder + 1);
                                    } else {
                                        $set('order', 1);
                                    }
                                }),
                            TextInput::make('order')
                                ->label(__('Priority'))
                                ->columnSpan(4)
                                ->numeric()
                                ->dehydrated()
                                ->reactive()
                                ->default(1)
                        ]),
                        RichEditor::make('description')
                            ->label(__('Description'))
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $plainText = strip_tags($state);

                                $seoDesc = str($plainText)->limit(160);

                                // ambil kata2
                                $words = str($plainText)
                                    ->lower()
                                    ->explode(' ')
                                    ->map(fn($word) => trim(preg_replace('/[^a-z0-9]/', '', $word)))
                                    ->filter(fn($word) => strlen($word) > 3) // minimal panjang kata
                                    ->unique()
                                    ->take(10)
                                    ->implode(', ');

                                $set('seoMeta.meta_description', $seoDesc);
                                $set('seoMeta.keywords', $words);
                            })
                            ->required(),
                        Grid::make(12)->schema([
                            RichEditor::make('notes')
                                ->columnSpan(6)
                                ->label(__('Notes')),
                            RichEditor::make('itinerary')
                                ->columnSpan(6)
                                ->label(__('Itinerary')),
                        ]),
                        Grid::make(12)->schema([
                            RichEditor::make('include')
                                ->label(__('Include'))
                                ->columnSpan(6),
                            RichEditor::make('exclude')
                                ->label(__('Exclude'))
                                ->columnSpan(6),
                        ]),
                        CuratorPicker::make('media')
                            ->label(__('Thumbnail'))
                            ->relationship('media', 'id')
                            ->multiple()
                    ]),
                    Tab::make('Packet')->schema([
                        Repeater::make('packet')
                            ->label(__('Packets'))
                            ->schema([
                                TextInput::make('value')
                                    ->label(__('Packet (Price & Person)'))
                                    ->placeholder('e.g: 1 Person - 500.000 or 1 pack - 1.000.000')
                                    ->required(),
                            ])
                            ->minItems(1)
                            ->defaultItems(1)
                            ->collapsible()
                            ->required(),
                        Grid::make(12)->schema([
                            TextInput::make('discount')
                                ->numeric()->prefix('Rp')->label(__('Discount'))
                                ->columnSpan(4),
                            DatePicker::make('discount_start')
                                ->label(__('Start'))->columnSpan(4),
                            DatePicker::make('discount_end')
                                ->label(__('End'))->columnSpan(4),
                        ]),
                    ]),
                    Tab::make('SEO')->schema([
                        TextInput::make('seoMeta.meta_title')
                            ->label(__('Meta Title')),
                        Textarea::make('seoMeta.meta_description')
                            ->label(__('Meta Description')),
                        TextInput::make('seoMeta.keywords')
                            ->label(__('Keywords')),
                        TextInput::make('seoMeta.canonical_url')->label(__('Canonical URL')),
                        TextInput::make('seoMeta.robots')->label(__('Robots'))->default('index, follow'),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('media.0.path')
                ->label(__('Thumbnail'))
                ->disk('public')
                ->size(60),
            TextColumn::make('title')->label(__('Title'))->sortable()->searchable(),
            TextColumn::make('category.name')->label(__('Category'))->sortable(),
            // TextColumn::make('packet')
            //     ->label('Packets')
            //     ->getStateUsing(fn($record) => $record->packet)
            //     ->formatStateUsing(function ($state) {
            //         if (! is_array($state)) {
            //             return '-';
            //         }

            //         return collect($state)
            //             ->pluck('value')
            //             ->implode("\n") ?: '-';
            //     })
            //     ->wrap()
            //     ->limit(50),
            TextColumn::make('duration')->label(__('Duration (days)')),
            TextColumn::make('order')->label(__('Priority')),
        ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                // EditAction::make('view')
                //     ->label('View')
                //     ->url(fn (Tour $record): string => route('tours.show', $record->slug))
                //     ->icon('heroicon-o-eye')
                //     ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['category', 'media'])
            ->orderBy(Category::select('order')->whereColumn('categories.id', 'tours.category_id'))
            ->orderBy('order');
    }
}
