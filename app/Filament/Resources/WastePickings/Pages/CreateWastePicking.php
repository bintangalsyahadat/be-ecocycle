<?php

namespace App\Filament\Resources\WastePickings\Pages;

use App\Enums\WasteMoveState;
use App\Filament\Resources\WastePickings\WastePickingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWastePicking extends CreateRecord
{
    protected static string $resource = WastePickingResource::class;

    protected function afterCreate(): void
    {
        parent::afterCreate();

        // Sync date, branch_id, and state to all waste moves
        foreach ($this->record->wasteMoves as $move) {
            $move->update([
                'date' => $this->record->date,
                'branch_id' => $this->record->branch_id,
                'state' => WasteMoveState::Forecasted,
            ]);
        }
    }
}
