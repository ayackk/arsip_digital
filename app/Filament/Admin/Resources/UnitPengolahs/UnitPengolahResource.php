<?php

namespace App\Filament\Admin\Resources\UnitPengolahs;

use App\Filament\Admin\Resources\UnitPengolahs\Pages\CreateUnitPengolah;
use App\Filament\Admin\Resources\UnitPengolahs\Pages\EditUnitPengolah;
use App\Filament\Admin\Resources\UnitPengolahs\Pages\ListUnitPengolahs;
use App\Filament\Admin\Resources\UnitPengolahs\Schemas\UnitPengolahForm;
use App\Filament\Admin\Resources\UnitPengolahs\Tables\UnitPengolahsTable;
use App\Models\UnitPengolah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UnitPengolahResource extends Resource
{
    protected static ?string $model = UnitPengolah::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UnitPengolahForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnitPengolahsTable::configure($table);
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
            'index' => ListUnitPengolahs::route('/'),
            'create' => CreateUnitPengolah::route('/create'),
            'edit' => EditUnitPengolah::route('/{record}/edit'),
        ];
    }
}
