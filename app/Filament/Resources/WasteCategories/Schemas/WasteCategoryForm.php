<?php

namespace App\Filament\Resources\WasteCategories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WasteCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->default(null),
                FileUpload::make('image_path')
                    ->image()
                    ->directory('waste-categories'),
                TextInput::make('sales_price')
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),
                TextInput::make('purchase_price')
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),
            ]);
    }
}
