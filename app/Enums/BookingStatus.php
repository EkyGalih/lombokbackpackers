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
            self::Pending   => 'Waiting Payment',
            self::Waiting   => 'Waiting Confirmation',
            self::Approved  => 'Approved',
            self::Rejected  => 'Rejected',
            self::Cancelled => 'Cancelled',
            self::Expired   => 'Expired',
            self::Refunded  => 'Refunded',
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

    public static function formOptions(): array
    {
        return collect(self::cases())
            ->filter(fn(self $case) => in_array($case, [
                self::Approved,
                self::Rejected,
                self::Cancelled,
                self::Refunded
            ]))
            ->mapWithKeys(fn(self $case) => [$case->value => $case->label()])
            ->toArray();
    }
}
