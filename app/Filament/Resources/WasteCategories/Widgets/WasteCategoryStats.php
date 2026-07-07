<?php

namespace App\Filament\Resources\WasteCategories\Widgets;

use App\Models\WasteCategory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WasteCategoryStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Categories', WasteCategory::count())
                ->label('Total Categories'),
        ];
    }
}
