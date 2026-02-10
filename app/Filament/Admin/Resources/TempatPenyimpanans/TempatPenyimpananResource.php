<?php

namespace App\Filament\Admin\Resources\TempatPenyimpanans;

use App\Filament\Admin\Resources\TempatPenyimpanans\Pages\CreateTempatPenyimpanan;
use App\Filament\Admin\Resources\TempatPenyimpanans\Pages\EditTempatPenyimpanan;
use App\Filament\Admin\Resources\TempatPenyimpanans\Pages\ListTempatPenyimpanans;
use App\Filament\Admin\Resources\TempatPenyimpanans\Schemas\TempatPenyimpananForm;
use App\Filament\Admin\Resources\TempatPenyimpanans\Tables\TempatPenyimpanansTable;
use App\Models\TempatPenyimpanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class TempatPenyimpananResource extends Resource
{
    protected static ?string $model = TempatPenyimpanan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Tempat Penyimpanan';

    protected static ?string $modelLabel = 'Tempat Penyimpanan';

    protected static ?string $pluralModelLabel = 'Tempat Penyimpanan';

    public static function form(Schema $schema): Schema
    {
        return TempatPenyimpananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TempatPenyimpanansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

        public static function getEloquentQuery(): Builder
    {
    $query = parent::getEloquentQuery();
    $user = Auth::user();

    // Jika yang login adalah operator, filter hanya data milik OPD-nya
    if ($user && $user->role !== 'admin') {
        $query->where('opd_id', $user->opd_id);
    }

    return $query;
    }


    public static function getPages(): array
    {
        return [
            'index' => ListTempatPenyimpanans::route('/'),
            'create' => CreateTempatPenyimpanan::route('/create'),
            'edit' => EditTempatPenyimpanan::route('/{record}/edit'),
        ];
    }
}
