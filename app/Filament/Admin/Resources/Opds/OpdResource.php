<?php

namespace App\Filament\Admin\Resources\Opds;

use App\Filament\Admin\Resources\Opds\Pages\CreateOpd;
use App\Filament\Admin\Resources\Opds\Pages\EditOpd;
use App\Filament\Admin\Resources\Opds\Pages\ListOpds;
use App\Filament\Admin\Resources\Opds\Schemas\OpdForm;
use App\Filament\Admin\Resources\Opds\Tables\OpdsTable;
use App\Models\Opd;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class OpdResource extends Resource
{
    protected static ?string $model = Opd::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?string $navigationLabel = 'OPD';

    protected static ?string $modelLabel = 'OPD';

    protected static ?string $pluralModelLabel = 'OPD';

    public static function form(Schema $schema): Schema
    {
        return OpdForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OpdsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();

        return $user && $user->role === 'admin';
    }

    public static function getEloquentQuery(): Builder
    {
    $query = parent::getEloquentQuery();
    $user = Auth::user();

    // Jika yang login adalah operator, filter data berdasarkan opd_id si user
    if ($user->role === 'operator') {
        $query->where('opd_id', $user->opd_id);
    }

    return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOpds::route('/'),
            'create' => CreateOpd::route('/create'),
            'edit' => EditOpd::route('/{record}/edit'),
        ];
    }
}
