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
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Illuminate\Support\Facades\Storage;

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
            TextColumn::make('opd.nama_opd')
                ->label('OPD'),
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
                SelectFilter::make('opd_id')
                    ->relationship('opd', 'nama_opd')
                    ->label('Filter OPD'),
        ])
        ->actions([
        ViewAction::make(),
        EditAction::make(),

        // TOMBOL DOWNLOAD
        Action::make('download')
            ->label('Download')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('info')
            ->action(function ($record) {
        // Kita ambil path file langsung dari storage app public
        $filePath = storage_path('app/public/' . $record->lokasi_file);

        // Cek apakah filenya beneran ada di folder tersebut
        if (file_exists($filePath)) {
            // Kita buat nama file downloadnya rapi berdasarkan judul arsip
            $namaFile = str($record->judul_arsip)->slug() . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

            // Return response download (Ini yang bikin gak akan kena 403)
            return response()->download($filePath, $namaFile);
        }
            })
            ->openUrlInNewTab()
            ->visible(fn ($record) => !empty($record->lokasi_file)),
        ])
            ->toolbarActions([
                    BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
