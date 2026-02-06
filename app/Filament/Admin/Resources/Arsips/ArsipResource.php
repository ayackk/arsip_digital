<?php

namespace App\Filament\Admin\Resources\Arsips;

use App\Filament\Admin\Resources\Arsips\Pages\CreateArsip;
use App\Filament\Admin\Resources\Arsips\Pages\EditArsip;
use App\Filament\Admin\Resources\Arsips\Pages\ListArsips;
use App\Filament\Admin\Resources\Arsips\Schemas\ArsipForm;
use App\Filament\Admin\Resources\Arsips\Tables\ArsipsTable;
use App\Models\ArsipDokumen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ArsipResource extends Resource
{
    protected static ?string $model = ArsipDokumen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Arsip';

    public static function form(Schema $schema): Schema
    {
        return ArsipForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArsipsTable::configure($table);
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
            'index' => ListArsips::route('/'),
            'create' => CreateArsip::route('/create'),
            'edit' => EditArsip::route('/{record}/edit'),
        ];
    }
}
