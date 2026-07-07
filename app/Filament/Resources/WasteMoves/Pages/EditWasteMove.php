<?php

namespace App\Filament\Resources\WasteMoves\Pages;

use App\Filament\Resources\WasteMoves\WasteMoveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWasteMove extends EditRecord
{
    protected static string $resource = WasteMoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
