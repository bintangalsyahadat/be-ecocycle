<?php

namespace App\Filament\Resources\WasteCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WasteCategoriesTable
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
                TextColumn::make('sales_price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('purchase_price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('stock_move_in')
                    ->numeric()
                    ->sortable()
                    ->label('Stock In'),
                TextColumn::make('stock_move_out')
                    ->numeric()
                    ->sortable()
                    ->label('Stock Out'),
                TextColumn::make('stock_forecasted')
                    ->numeric()
                    ->sortable()
                    ->label('Forecasted')
                    ->color(fn ($state): string => $state >= 0 ? 'success' : 'danger'),
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
