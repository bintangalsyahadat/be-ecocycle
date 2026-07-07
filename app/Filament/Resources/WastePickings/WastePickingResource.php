<?php

namespace App\Filament\Resources\WastePickings;

use App\Filament\Resources\WastePickings\Pages\CreateWastePicking;
use App\Filament\Resources\WastePickings\Pages\EditWastePicking;
use App\Filament\Resources\WastePickings\Pages\ListWastePickings;
use App\Filament\Resources\WastePickings\RelationManagers\WasteMovesRelationManager;
use App\Filament\Resources\WastePickings\Schemas\WastePickingForm;
use App\Filament\Resources\WastePickings\Tables\WastePickingsTable;
use App\Models\WastePicking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class WastePickingResource extends Resource
{
    protected static ?string $model = WastePicking::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Schema $schema): Schema
    {
        return WastePickingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WastePickingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            WasteMovesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWastePickings::route('/'),
            'create' => CreateWastePicking::route('/create'),
            'edit' => EditWastePicking::route('/{record}/edit'),
        ];
    }
}
