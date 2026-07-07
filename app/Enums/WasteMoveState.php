<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum WasteMoveState: string implements HasLabel, HasColor, HasIcon
{
    case Forecasted = 'forecasted';
    case Done = 'done';
    case Cancel = 'cancel';

    public function getLabel(): string
    {
        return match ($this) {
            self::Forecasted => 'Forecasted',
            self::Done => 'Done',
            self::Cancel => 'Cancelled',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Forecasted => 'warning',
            self::Done => 'success',
            self::Cancel => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Forecasted => 'heroicon-o-clock',
            self::Done => 'heroicon-o-check-circle',
            self::Cancel => 'heroicon-o-x-circle',
        };
    }
}
