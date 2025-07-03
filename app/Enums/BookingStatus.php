<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending   = 'pending';
    case Waiting   = 'waiting';
    case Approved  = 'approved';
    case Rejected  = 'rejected';
    case Cancelled = 'cancelled';
    case Expired   = 'expired';
    case Refunded  = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending   => 'Menunggu Pembayaran',
            self::Waiting   => 'Menunggu Konfirmasi',
            self::Approved  => 'Disetujui',
            self::Rejected  => 'Ditolak',
            self::Cancelled => 'Dibatalkan',
            self::Expired   => 'Kadaluarsa',
            self::Refunded  => 'Dana Dikembalikan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending   => 'warning',
            self::Waiting   => 'gray',
            self::Approved  => 'success',
            self::Rejected  => 'danger',
            self::Cancelled => 'gray',
            self::Expired   => 'gray',
            self::Refunded  => 'info',
        };
    }
}
