<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Pemesanan';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Pemesan')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('tour_id')
                ->label('Paket Tour')
                ->relationship('tour', 'title')
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('booking_date')
                ->label('Tanggal Pemesanan')
                ->required(),

            Forms\Components\TextInput::make('total_price')
                ->label('Total Harga')
                ->prefix('Rp')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Lunas',
                    'cancelled' => 'Dibatalkan',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Pemesan')->searchable(),
                Tables\Columns\TextColumn::make('tour.title')->label('Paket Tour'),
                Tables\Columns\TextColumn::make('booking_date')->label('Tanggal'),
                Tables\Columns\TextColumn::make('total_price')->label('Total')->money('IDR', true),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'primary' => 'pending',
                    'success' => 'paid',
                    'danger' => 'cancelled',
                ]),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
