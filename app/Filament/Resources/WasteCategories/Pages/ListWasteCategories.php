<?php

namespace App\Filament\Resources\WasteCategories\Pages;

use App\Filament\Resources\WasteCategories\WasteCategoryResource;
use App\Filament\Resources\WasteCategories\Widgets\WasteCategoryStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWasteCategories extends ListRecords
{
    protected static string $resource = WasteCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WasteCategoryStats::class,
        ];
    }
}
