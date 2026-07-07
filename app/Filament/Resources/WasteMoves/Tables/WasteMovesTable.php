<?php

namespace App\Filament\Resources\WasteMoves\Tables;

use App\Enums\WasteMoveType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;

class WasteMovesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('valid_qty')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('state')
                    ->badge()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'name'),
                Filter::make('incoming')
                    ->query(fn (Builder $query): Builder => $query->where('type', WasteMoveType::Incoming))
                    ->label('Incoming'),
                Filter::make('outgoing')
                    ->query(fn (Builder $query): Builder => $query->where('type', WasteMoveType::Outgoing))
                    ->label('Outgoing'),
            ])
            ->groups([
                Group::make('branch_id'),
                Group::make('category_id'),
                Group::make('type'),
                Group::make('state'),
            ])
            ->defaultSort('date', 'desc')
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
