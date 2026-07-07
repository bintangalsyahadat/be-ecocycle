<?php

namespace App\Filament\Resources\WastePickings\RelationManagers;

use App\Models\WastePicking;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class WasteMovesRelationManager extends RelationManager
{
    protected static string $relationship = 'wasteMoves';
    protected static ?string $recordTitleAttribute = 'id';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch_id')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('id', 'asc')
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                //
            ]);
    }
}
