<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum WastePickingState: string implements HasLabel, HasColor, HasIcon
{
    case Draft = 'draft';
    case Confirm = 'confirm';
    case Done = 'done';
    case Cancel = 'cancel';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Confirm => 'Confirmed',
            self::Done => 'Done',
            self::Cancel => 'Cancelled',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Confirm => 'info',
            self::Done => 'success',
            self::Cancel => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Draft => 'heroicon-o-pencil',
            self::Confirm => 'heroicon-o-check',
            self::Done => 'heroicon-o-check-circle',
            self::Cancel => 'heroicon-o-x-circle',
        };
    }
}
