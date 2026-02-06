<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ArsipDokumen;
use Filament\Widgets\ChartWidget;

class ArsipChart extends ChartWidget
{
    protected ?string $heading = 'Arsip per Bulan';

    protected function getData(): array
    {
        $raw = ArsipDokumen::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = $raw[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Arsip',
                    'data' => $data,
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
