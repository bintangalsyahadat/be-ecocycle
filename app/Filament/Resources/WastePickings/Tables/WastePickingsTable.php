<?php

namespace App\Filament\Resources\WastePickings\Tables;

use App\Enums\WastePickingState;
use App\Models\WastePicking;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WastePickingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('partner.name')
                    ->label('Partner')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('branch.name')
                    ->label('Branch')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('deliveryMethod.name')
                    ->label('Delivery Method')
                    ->sortable(),
                TextColumn::make('state')
                    ->badge()
                    ->color(fn (WastePickingState $state): string => $state->getColor()),
            ])
            ->filters([
                SelectFilter::make('state')
                    ->options(WastePickingState::class),
            ])
            ->recordActions([
                EditAction::make(),
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
                    }),
                Action::make('done')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (WastePicking $record) => $record->state === WastePickingState::Confirm)
                    ->modalHeading(fn (WastePicking $record) => "Mark Done: {$record->name}")
                    ->mountUsing(function ($form, WastePicking $record) {
                        $form->fill([
                            'moves' => $record->wasteMoves->map(fn ($move) => [
                                'id' => $move->id,
                                'category_name' => $move->category?->name ?? 'N/A',
                                'quantity' => $move->quantity,
                                'valid_qty' => $move->valid_qty ?? $move->quantity,
                            ])->toArray(),
                        ]);
                    })
                    ->form([
                        Repeater::make('moves')
                            ->schema([
                                Hidden::make('id'),
                                TextInput::make('category_name')
                                    ->disabled()
                                    ->label('Category'),
                                TextInput::make('quantity')
                                    ->disabled()
                                    ->numeric()
                                    ->label('Quantity'),
                                TextInput::make('valid_qty')
                                    ->numeric()
                                    ->required()
                                    ->label('Valid Qty'),
                            ])
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false),
                    ])
                    ->action(function (WastePicking $record, array $data) {
                        foreach ($data['moves'] as $moveData) {
                            $move = $record->wasteMoves()->find($moveData['id']);
                            if ($move) {
                                $move->update(['valid_qty' => $moveData['valid_qty']]);
                            }
                        }
                        $record->actionDone();
                        Notification::make()
                            ->title('Waste picking marked as done')
                            ->success()
                            ->send();
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
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
