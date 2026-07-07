<?php

namespace App\Filament\Resources\DeliveryMethods\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryMethodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable()
                    ->limit(50),
                IconColumn::make('is_self_service')
                    ->boolean(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (\App\Enums\DeliveryMethodType $state): string => $state->getColor()),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
