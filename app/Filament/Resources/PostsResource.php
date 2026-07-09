<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostsResource\Pages;
use App\Models\Posts;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;

class PostsResource extends Resource
{
    use Translatable;

    protected static ?string $model = Posts::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return __('Blog');
    }

    public static function getModelLabel(): string
    {
        return __('Blog');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Blog');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Detail Posts')->schema([
                            Grid::make(12)
                                ->schema([
                                    TextInput::make('title')
                                        ->label(__('Title'))
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            // Kalau SEO title masih kosong
                                            $set('seoMeta.meta_title', $state);
                                            // Kalau slug masih kosong
                                            $set('slug', str($state)->slug());
                                            // set url seo
                                            $set('seoMeta.canonical_url', url(ENV('APP_URL') . '/blog/' . str($state)->slug()));
                                        })
                                        ->columnSpan(12)
                                ]),
                            RichEditor::make('excerpt')
                                ->label(__('Excerpt'))
                                ->hidden(),
                            RichEditor::make('content')
                                ->label(__('Content'))
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $plainText = strip_tags($state);

                                    $excerpt = str($plainText)->limit(100);
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

                                    $set('excerpt', $excerpt);
                                    $set('seoMeta.meta_description', $seoDesc);
                                    $set('seoMeta.keywords', $words);
                                })
                                ->required(),

                            Grid::make(12)
                                ->schema([
                                    Grid::make(12)
                                        ->schema([
                                            TagsInput::make('tags')
                                                ->label(__('Tags'))
                                                ->dehydrateStateUsing(fn($state) => $state ?? [])
                                                ->columnSpan(6),
                                            Select::make('category')
                                                ->label(__('Category'))
                                                ->options([
                                                    'blog' => 'Blog',
                                                    'stories' => 'Stories',
                                                    'tips' => 'Tips',
                                                    'other' => 'Other',
                                                ])
                                                ->columnSpan(6),
                                        ]),
                                ]),
                            Grid::make(12)
                                ->schema([
                                    Toggle::make('status')
                                        ->label(__('Published?'))
                                        ->inline(false)
                                        ->onColor('success')
                                        ->offColor('danger')
                                        ->onIcon('heroicon-m-check')
                                        ->offIcon('heroicon-m-x-mark')
                                        ->columnSpan(3)
                                        ->required(),
                                    Toggle::make('is_popular_post')
                                        ->label(__('Make a Popular Content?'))
                                        ->inline(false)
                                        ->onColor('success')
                                        ->offColor('danger')
                                        ->onIcon('heroicon-m-check')
                                        ->offIcon('heroicon-m-x-mark')
                                        ->columnSpan(3),
                                    CuratorPicker::make('media')
                                        ->label(__('Thumbnail'))
                                        ->multiple()
                                        ->columnSpan(6),
                                ]),

                            Hidden::make('author_id')->default(auth()->id()),
                        ]),
                        Tab::make('SEO')->schema([
                            TextInput::make('seoMeta.meta_title')
                                ->label(__('Meta Title')),
                            Textarea::make('seoMeta.meta_description')
                                ->label(__('Meta Description')),
                            TextInput::make('seoMeta.keywords')
                                ->label(__('Keywords')),
                            TextInput::make('seoMeta.canonical_url')->readOnly()->label(__('Canonical URL')),
                            TextInput::make('seoMeta.robots')
                                ->readOnly()
                                ->label(__('Robots'))
                                ->default('index, follow')
                                ->afterStateHydrated(function (\Filament\Forms\Components\Component $component, $state) {
                                    if (blank($state)) {
                                        $component->state('index, follow');
                                    }
                                }),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Posts::query() // ⬅️ ini penting: ambil data dari model Post
                    ->with(['author', 'media']) // eager load relasi
            )
            ->columns([
                ImageColumn::make('media.0.path')
                    ->label(__('Thumbnail'))
                    ->disk('public')
                    ->size(50),
                TextColumn::make('title')->label(__('Title'))->searchable(),
                TextColumn::make('author.name')->label(__('Author')),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn(bool $state) => $state ? 'published' : 'draft')
                    ->colors([
                        'draft' => 'secondary',
                        'published' => 'success',
                    ]),
                TextColumn::make('is_popular_post')
                    ->label(__('Popular Post'))
                    ->badge()
                    ->formatStateUsing(fn(bool $state) => $state ? 'Yes' : 'No')
                    ->colors([
                        'Yes' => 'success',
                        'No' => 'secondary',
                    ]),
                TextColumn::make('created_at')->label(__('Published At'))->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePosts::route('/create'),
            'edit' => Pages\EditPosts::route('/{record}/edit'),
        ];
    }
}
