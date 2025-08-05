<?php

namespace App\Filament\Resources;

use App\Enums\BookingStatus;
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
                ->options(BookingStatus::formOptions())
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking.user.name')->label('Customer'),
                Tables\Columns\TextColumn::make('code_payment')->label('Booking Code'),
                Tables\Columns\TextColumn::make('amount')->label('Payed')->money('IDR', true),
                Tables\Columns\ImageColumn::make('media.0.path')->label('Proof File')->size(50),
                Tables\Columns\TextColumn::make('paid_at')->date('d M Y')->label('Payment Date'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn(string $state) => BookingStatus::from($state)->label())
                    ->colors(fn(string $state) => [
                        BookingStatus::from($state)->color() => $state,
                    ])
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
            // 'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
