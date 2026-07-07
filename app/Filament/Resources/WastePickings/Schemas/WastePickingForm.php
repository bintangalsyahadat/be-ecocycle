<?php

namespace App\Filament\Resources\WastePickings\Schemas;

use App\Enums\WasteMoveType;
use App\Models\WasteCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WastePickingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->disabled()
                    ->helperText('Auto-generated on confirm'),
                DateTimePicker::make('date')
                    ->required()
                    ->default(now()),
                Select::make('partner_id')
                    ->label('Partner')
                    ->relationship('partner', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->createOptionForm([
                        TextInput::make('name')->required(),
                        Textarea::make('address')->nullable(),
                        TextInput::make('phone')->nullable(),
                        TextInput::make('email')->nullable()->email(),
                    ]),
                Select::make('branch_id')
                    ->label('Branch')
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->default(fn () => auth()->user()?->branches()?->first()?->id),
                Select::make('delivery_method_id')
                    ->label('Delivery Method')
                    ->relationship('deliveryMethod', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Placeholder::make('state_display')
                    ->label('State')
                    ->content(fn ($record) => $record?->state ? $record->state->getLabel() : 'Draft'),
                // TextInput::make('purchase_transaction_id')
                //     ->numeric()
                //     ->default(null),
                // TextInput::make('sale_transaction_id')
                //     ->numeric()
                //     ->default(null),
                Repeater::make('wasteMoves')
                    ->relationship('wasteMoves')
                    ->label('Waste Move Lines')
                    ->orderColumn('id')
                    ->columns(2)
                    ->schema([
                        Select::make('category_id')
                            ->label('Waste Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('type')
                            ->options(WasteMoveType::class)
                            ->required()
                            ->default(WasteMoveType::Incoming),
                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(0),
                        TextInput::make('valid_qty')
                            ->numeric()
                            ->default(0),
                        TextInput::make('date')
                            ->hidden()
                            ->default(now()),
                        Select::make('state')
                            ->hidden()
                            ->options([
                                'forecasted' => 'Forecasted',
                                'done' => 'Done',
                                'cancel' => 'Cancelled',
                            ])
                            ->default('forecasted'),
                        TextInput::make('branch_id')
                            ->hidden()
                            ->default(fn () => auth()->user()?->branches()?->first()?->id),
                    ])
                    ->columnSpanFull()
                    ->defaultItems(0)
                    ->addActionLabel('Add Move Line')
                    ->collapsible()
                    ->cloneable(),
            ]);
    }
}
