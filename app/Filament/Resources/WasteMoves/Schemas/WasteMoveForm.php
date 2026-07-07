<?php

namespace App\Filament\Resources\WasteMoves\Schemas;

use App\Enums\WasteMoveState;
use App\Enums\WasteMoveType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WasteMoveForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('date')
                    ->required()
                    ->default(now()),
                Select::make('type')
                    ->options(WasteMoveType::class)
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('branch_id')
                    ->numeric(),
                TextInput::make('quantity')
                    ->numeric()
                    ->default(0.0),
                TextInput::make('valid_qty')
                    ->numeric()
                    ->default(0.0),
                Select::make('state')
                    ->options(WasteMoveState::class)
                    ->default('forecasted')
                    ->required(),
                Select::make('waste_picking_id')
                    ->relationship('wastePicking', 'name')
                    ->searchable(),
            ]);
    }
}
