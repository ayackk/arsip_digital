<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ArsipDokumen;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ArsipTerbaru extends TableWidget
{
    protected static ?string $heading = 'Arsip Terbaru';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ArsipDokumen::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('judul_arsip')->label('Judul'),

                TextColumn::make('unitPengolah.nama_unit')->label('Unit'),

                TextColumn::make('jenisArsip.nama_jenis')->label('Jenis'),

                TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y H:i'),
            ]);
    }
}
