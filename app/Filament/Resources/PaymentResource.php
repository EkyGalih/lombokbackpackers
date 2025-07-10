<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Payments';
    protected static ?string $navigationGroup = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('booking_id')
                ->label('Kode Booking')
                ->relationship('booking', 'id')
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('payment_date')
                ->label('Tanggal Pembayaran')
                ->required(),

            Forms\Components\TextInput::make('amount')
                ->label('Jumlah Pembayaran')
                ->prefix('Rp')
                ->numeric()
                ->required(),

            Forms\Components\FileUpload::make('proof_image')
                ->label('Bukti Pembayaran')
                ->image()
                ->directory('payments'),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'waiting' => 'Menunggu Konfirmasi',
                    'confirmed' => 'Dikonfirmasi',
                    'rejected' => 'Ditolak',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking.user.name')->label('Pemesan'),
                Tables\Columns\TextColumn::make('amount')->label('Jumlah')->money('IDR', true),
                Tables\Columns\ImageColumn::make('proof_image')->label('Bukti')->size(50),
                Tables\Columns\TextColumn::make('payment_date')->label('Tanggal'),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'warning' => 'waiting',
                    'success' => 'confirmed',
                    'danger' => 'rejected',
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
