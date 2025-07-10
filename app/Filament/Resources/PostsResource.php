<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostsResource\Pages;
use App\Filament\Resources\PostsResource\RelationManagers;
use App\Models\Posts;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsResource extends Resource
{
    protected static ?string $model = Posts::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationLabel = 'Posts';
    protected static ?string $modelLabel = 'Kategori';
    protected static ?string $pluralModelLabel = 'Posts';
    protected static ?int $navigationSort = 4;

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
                                        ->formatStateUsing(function ($state) {
                                            if (is_array($state)) {
                                                return $state[app()->getLocale()] ?? '';
                                            }
                                            return $state;
                                        })
                                        ->columnSpan(6)
                                        ->required(),
                                    TextInput::make('slug')
                                        ->readonly()
                                        ->formatStateUsing(function ($state) {
                                            if (is_array($state)) {
                                                return $state[app()->getLocale()] ?? '';
                                            }
                                            return $state;
                                        })
                                        ->columnSpan(6)
                                        ->required()
                                        ->unique(ignoreRecord: true),
                                ]),
                            Textarea::make('excerpt')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                }),
                            RichEditor::make('content')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                })
                                ->required(),

                            Grid::make(12)
                                ->schema([
                                    CuratorPicker::make('thumbnail')
                                        ->label('Thumbnail')
                                        ->multiple()
                                        ->columnSpan(6),
                                    TagsInput::make('tags')
                                        ->label('Tags')
                                        ->formatStateUsing(function ($state) {
                                            if (is_array($state)) {
                                                return $state[app()->getLocale()] ?? '';
                                            }
                                            return $state;
                                        })
                                        ->columnSpan(6),
                                ]),

                            Grid::make(12)
                                ->schema([
                                    Select::make('author_id')
                                        ->relationship('author', 'name')
                                        ->columnSpan(6)
                                        ->nullable(),

                                    Select::make('status')
                                        ->columnSpan(6)
                                        ->options([
                                            'draft' => 'Draft',
                                            'published' => 'Published',
                                        ])->default('draft'),
                                ]),
                        ]),
                        Tab::make('SEO')->schema([
                            TextInput::make('seoMeta.meta_title')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                })
                                ->label('Meta Title'),
                            Textarea::make('seoMeta.meta_description')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                })
                                ->label('Meta Description'),
                            TextInput::make('seoMeta.keywords')
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return $state[app()->getLocale()] ?? '';
                                    }
                                    return $state;
                                })
                                ->label('Keywords'),
                            TextInput::make('seoMeta.canonical_url')->label('Canonical URL'),
                            TextInput::make('seoMeta.robots')->label('Robots')->default('index, follow'),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Posts::query() // ⬅️ ini penting: ambil data dari model Post
                    ->with(['author']) // eager load relasi
            )
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->size(50),
                TextColumn::make('title')->searchable(),
                TextColumn::make('author.name')->label('Author'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'draft' => 'secondary',
                        'published' => 'success',
                    ]),
                TextColumn::make('created_at')->label('Published At')->dateTime(),
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
