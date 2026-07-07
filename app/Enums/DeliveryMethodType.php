<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DeliveryMethodType: string implements HasLabel, HasColor
{
    case Incoming = 'incoming';
    case Outgoing = 'outgoing';

    public function getLabel(): string
    {
        return match ($this) {
            self::Incoming => 'Pemasukan Sampah',
            self::Outgoing => 'Pengiriman Sampah',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Incoming => 'success',
            self::Outgoing => 'warning',
        };
    }
}
