<?php

namespace App\Filament\Resources\WasteMoves\Pages;

use App\Filament\Resources\WasteMoves\WasteMoveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Concerns\HasFilters;

class ListWasteMoves extends ListRecords
{
    use HasFilters;

    protected static string $resource = WasteMoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
