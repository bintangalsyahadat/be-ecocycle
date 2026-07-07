<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum WasteMoveType: string implements HasLabel, HasColor, HasIcon
{
    case Incoming = 'incoming';
    case Outgoing = 'outgoing';

    public function getLabel(): string
    {
        return match ($this) {
            self::Incoming => 'Incoming',
            self::Outgoing => 'Outgoing',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Incoming => 'success',
            self::Outgoing => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Incoming => 'heroicon-o-arrow-down-tray',
            self::Outgoing => 'heroicon-o-arrow-up-tray',
        };
    }
}
