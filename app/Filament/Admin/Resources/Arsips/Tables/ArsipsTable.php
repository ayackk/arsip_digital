<?php

namespace App\Filament\Admin\Resources\Arsips\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;

class ArsipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('judul_arsip')
                ->searchable()
                ->sortable(),
            TextColumn::make('tanggal_naskah')
                ->date()
                ->sortable(),
            TextColumn::make('unitPengolah.nama_unit')
                ->label('Unit'),
            TextColumn::make('jenisArsip.nama_jenis')
                ->label('Kategori'),
           TextColumn::make('penyimpanan.nama_ruangan')
                ->label('Tempat Penyimpanan')
                ->formatStateUsing(function ($record) {
                    if (!$record->penyimpanan) return '-';

                    return "{$record->penyimpanan->nama_ruangan} | Lemari {$record->penyimpanan->posisi_lemari} | Rak {$record->penyimpanan->posisi_rak} | Baris {$record->penyimpanan->baris}";
                })
    ->searchable(),
            TextColumn::make('lokasi_file')
                ->label('File'),
            ])
            ->filters([
                SelectFilter::make('unit_pengolah_id')
                    ->relationship('unitPengolah', 'nama_unit')
                    ->label('Filter Unit'),
            ])

            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                    BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
