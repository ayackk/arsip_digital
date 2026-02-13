<?php

namespace App\Filament\Admin\Resources\TingkatAkses;

use App\Filament\Admin\Resources\TingkatAkses\Pages\CreateTingkatAkses;
use App\Filament\Admin\Resources\TingkatAkses\Pages\EditTingkatAkses;
use App\Filament\Admin\Resources\TingkatAkses\Pages\ListTingkatAkses;
use App\Filament\Admin\Resources\TingkatAkses\Schemas\TingkatAksesForm;
use App\Filament\Admin\Resources\TingkatAkses\Tables\TingkatAksesTable;
use App\Models\TingkatAkses;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class TingkatAksesResource extends Resource
{
    protected static ?string $model = TingkatAkses::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Tingkat Akses';

    protected static ?string $modelLabel = 'Tingkat Akses';

    protected static ?string $pluralModelLabel = 'Tingkat Akses';

    public static function form(Schema $schema): Schema
    {
        return TingkatAksesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TingkatAksesTable::configure($table);
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

    public static function canViewAny(): bool
    {
        // Hanya user dengan role 'admin' atau 'operator' yang bisa melihat menu ini
        return in_array(Auth::user()->role, ['admin', 'operator']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTingkatAkses::route('/'),
            'create' => CreateTingkatAkses::route('/create'),
            'edit' => EditTingkatAkses::route('/{record}/edit'),
        ];
    }
}
