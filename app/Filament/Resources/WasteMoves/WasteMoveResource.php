<?php

namespace App\Filament\Resources\WasteMoves;

use App\Filament\Resources\WasteMoves\Pages\CreateWasteMove;
use App\Filament\Resources\WasteMoves\Pages\EditWasteMove;
use App\Filament\Resources\WasteMoves\Pages\ListWasteMoves;
use App\Filament\Resources\WasteMoves\Schemas\WasteMoveForm;
use App\Filament\Resources\WasteMoves\Tables\WasteMovesTable;
use App\Models\WasteMove;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class WasteMoveResource extends Resource
{
    protected static ?string $model = WasteMove::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-right-left';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return WasteMoveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WasteMovesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWasteMoves::route('/'),
            'create' => CreateWasteMove::route('/create'),
            'edit' => EditWasteMove::route('/{record}/edit'),
        ];
    }
}
