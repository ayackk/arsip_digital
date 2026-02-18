<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ArsipDokumen;
use App\Models\TempatPenyimpanan;
use App\Models\UnitPengolah;
use App\Models\JenisArsip;
use App\Filament\Admin\Resources\Arsips\ArsipResource;
use Illuminate\Support\Facades\Auth;

class ArsipStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Sistem';

        public static function canView(): bool
    {
    // Widget ini hanya bisa dilihat oleh Admin dan Operator
    return in_array(auth::user()->role, ['admin', 'operator']);
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Arsip', ArsipResource::getEloquentQuery()->count())
                ->description('Semua dokumen tersimpan')
                ->descriptionIcon('heroicon-m-document')
                ->color('primary'),

            Stat::make('Tempat Penyimpanan', TempatPenyimpanan::count())->description('Lokasi fisik')->descriptionIcon('heroicon-m-map-pin')->color('success'),

            Stat::make('Unit Pengolah', UnitPengolah::count())->description('Bidang')->descriptionIcon('heroicon-m-building-office')->color('warning'),

            Stat::make('Jenis Arsip', JenisArsip::count())->description('Kategori arsip')->descriptionIcon('heroicon-m-tag')->color('info'),
        ];
    }
}
