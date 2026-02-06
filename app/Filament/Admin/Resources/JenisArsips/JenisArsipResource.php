<?php

namespace App\Filament\Admin\Resources\JenisArsips;

use App\Filament\Admin\Resources\JenisArsips\Pages\CreateJenisArsip;
use App\Filament\Admin\Resources\JenisArsips\Pages\EditJenisArsip;
use App\Filament\Admin\Resources\JenisArsips\Pages\ListJenisArsips;
use App\Filament\Admin\Resources\JenisArsips\Schemas\JenisArsipForm;
use App\Filament\Admin\Resources\JenisArsips\Tables\JenisArsipsTable;
use App\Models\JenisArsip;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JenisArsipResource extends Resource
{
    protected static ?string $model = JenisArsip::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return JenisArsipForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisArsipsTable::configure($table);
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
            'index' => ListJenisArsips::route('/'),
            'create' => CreateJenisArsip::route('/create'),
            'edit' => EditJenisArsip::route('/{record}/edit'),
        ];
    }
}
