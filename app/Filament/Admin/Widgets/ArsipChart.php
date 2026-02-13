<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ArsipDokumen;
use Filament\Widgets\ChartWidget;
use App\Filament\Admin\Resources\Arsips\ArsipResource;

class ArsipChart extends ChartWidget
{
    protected ?string $heading = 'Arsip per Bulan';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1; // Jangan biarkan 'full' kalau mau sebelahan

    protected function getData(): array
    {
        // Panggil filter sakti dari Resource supaya data Private orang lain nggak ikut kehitung
        $query = ArsipResource::getEloquentQuery();

        $raw = $query->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')->groupBy('bulan')->pluck('total', 'bulan')->toArray();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = $raw[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Arsip',
                    'data' => $data,
                    'backgroundColor' => '#fbbf24', // Kasih warna biar keren (kuning/amber)
                    'borderColor' => '#fbbf24',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
