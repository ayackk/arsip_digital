<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ArsipDokumen;
use App\Models\TempatPenyimpanan;
use App\Models\UnitPengolah;
use App\Models\JenisArsip;
use App\Filament\Admin\Resources\Arsips\ArsipResource;

class ArsipStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Sistem';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Arsip', ArsipResource::getEloquentQuery()->count())
                ->description('Semua dokumen tersimpan')
                ->descriptionIcon('heroicon-m-document')
                ->color('primary'),

            Stat::make('Tempat Penyimpanan', TempatPenyimpanan::count())->description('Lokasi fisik')->descriptionIcon('heroicon-m-map-pin')->color('success'),

            Stat::make('Unit Pengolah', UnitPengolah::count())->description('Unit kerja')->descriptionIcon('heroicon-m-building-office')->color('warning'),

            Stat::make('Jenis Arsip', JenisArsip::count())->description('Kategori arsip')->descriptionIcon('heroicon-m-tag')->color('info'),
        ];
    }
}
