<?php

namespace App\Filament\Resources\DeliveryMethods\Schemas;

use App\Enums\DeliveryMethodType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DeliveryMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->nullable(),
                Toggle::make('is_self_service')
                    ->default(false),
                Select::make('type')
                    ->options(DeliveryMethodType::class)
                    ->required(),
            ]);
    }
}
