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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class ArsipResource extends Resource
{
    protected static ?string $model = ArsipDokumen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Arsip';

    protected static ?string $navigationLabel = 'Arsip Dokumen';

    protected static ?string $modelLabel = 'Arsip Dokumen';

    protected static ?string $pluralModelLabel = 'Arsip Dokumen';

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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        if (request()->routeIs('filament.admin.resources.arsips.create', 'filament.admin.resources.arsips.edit')) {
            return $query;
        }

        // Jika yang login adalah operator, filter hanya data milik OPD-nya
        if ($user->role === 'operator') {
            $query->where('opd_id', $user->opd_id);
        }

        return $query->where(function ($q) use ($user) {
            $q->whereHas('tingkatAkses', function ($t) {
                // Kondisi 1: PUBLIC - Semua orang bisa lihat
                $t->where('nama_tingkat', 'Public');
            })
                ->orWhere(function ($qInternal) use ($user) {
                    // Kondisi 2: INTERNAL - Hanya unit pengolah yang sama
                    $qInternal->whereHas('tingkatAkses', fn($t) => $t->where('nama_tingkat', 'Internal'))->where('unit_pengolah_id', $user->unit_pengolah_id);
                })
                ->orWhere(function ($qPrivate) use ($user) {
                    // Kondisi 3: PRIVATE - Hanya pengunggah asli
                    $qPrivate->whereHas('tingkatAkses', fn($t) => $t->where('nama_tingkat', 'Private'))->where('created_by', $user->id);
                });
        });
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
