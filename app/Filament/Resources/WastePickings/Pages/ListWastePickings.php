<?php

namespace App\Filament\Resources\WastePickings\Pages;

use App\Filament\Resources\WastePickings\WastePickingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWastePickings extends ListRecords
{
    protected static string $resource = WastePickingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
