<?php

namespace App\Filament\Resources\WastePickings\Pages;

use App\Enums\WasteMoveState;
use App\Enums\WastePickingState;
use App\Filament\Resources\WastePickings\WastePickingResource;
use App\Models\WastePicking;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditWastePicking extends EditRecord
{
    protected static string $resource = WastePickingResource::class;

    protected function afterSave(): void
    {
        parent::afterSave();

        // Sync date, branch_id, and state for any newly added moves
        foreach ($this->record->wasteMoves as $move) {
            $updates = [];

            if (empty($move->date)) {
                $updates['date'] = $this->record->date;
            }
            if (empty($move->branch_id)) {
                $updates['branch_id'] = $this->record->branch_id;
            }
            if (empty($move->state)) {
                $updates['state'] = WasteMoveState::Forecasted;
            }

            if (!empty($updates)) {
                $move->update($updates);
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('confirm')
                ->icon('heroicon-o-check')
                ->color('info')
                ->visible(fn (WastePicking $record) => $record->state === WastePickingState::Draft)
                ->action(function (WastePicking $record) {
                    $record->actionConfirm();
                    Notification::make()
                        ->title('Waste picking confirmed')
                        ->success()
                        ->send();

                    $this->redirect($this->getResource()::getUrl('edit', ['record' => $record]));
                }),
            Action::make('done')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (WastePicking $record) => $record->state === WastePickingState::Confirm)
                ->action(function (WastePicking $record) {
                    $record->actionDone();
                    Notification::make()
                        ->title('Waste picking marked as done')
                        ->success()
                        ->send();

                    $this->redirect($this->getResource()::getUrl('edit', ['record' => $record]));
                }),
            Action::make('cancel')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (WastePicking $record) => in_array($record->state, [WastePickingState::Draft, WastePickingState::Confirm], true))
                ->requiresConfirmation()
                ->modalHeading('Cancel Waste Picking')
                ->modalDescription('Are you sure you want to cancel this waste picking? This will also cancel all associated waste moves.')
                ->modalSubmitActionLabel('Yes, cancel it')
                ->action(function (WastePicking $record) {
                    $record->actionCancel();
                    Notification::make()
                        ->title('Waste picking cancelled')
                        ->success()
                        ->send();

                    $this->redirect($this->getResource()::getUrl('edit', ['record' => $record]));
                }),
            DeleteAction::make(),
        ];
    }
}
