<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ArsipDokumen;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Admin\Resources\Arsips\ArsipResource;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ArsipTerbaru extends TableWidget
{
    protected static ?string $heading = 'Arsip Terbaru';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            // Pakai query filter sakti kita agar tetap aman
            ->query(ArsipResource::getEloquentQuery())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('judul_arsip')->label('Judul arsip')->searchable()->sortable(),

                TextColumn::make('tanggal_naskah')->label('Tanggal naskah')->date()->sortable(),

                TextColumn::make('opd.nama_opd')->label('OPD')->sortable(),

                TextColumn::make('unitPengolah.nama_unit')->label('Unit')->sortable(),

                TextColumn::make('jenisArsip.nama_jenis')->label('Kategori')->sortable(),

                TextColumn::make('tingkatAkses.nama_tingkat')->label('Tingkat Akses')->badge()->color(
                    fn(string $state): string => match ($state) {
                        'Public' => 'success',
                        'Internal' => 'warning',
                        'Private' => 'danger',
                        default => 'gray',
                    },
                ),

                TextColumn::make('penyimpanan.nama_ruangan')
                    ->label('Tempat Penyimpanan')
                    ->formatStateUsing(function ($record) {
                        if (!$record->penyimpanan) {
                            return '-';
                        }

                        return "{$record->penyimpanan->nama_ruangan} | Lemari {$record->penyimpanan->posisi_lemari} | Rak {$record->penyimpanan->posisi_rak} | Baris {$record->penyimpanan->baris}";
                    })
                    ->searchable(),

                TextColumn::make('lokasi_file')
                    ->label('File')
                    ->icon('heroicon-m-document-text')
                    ->color('primary')
                    ->formatStateUsing(fn($state) => collect($state)->map(fn($path) => basename($path))->implode(', ')),

                 TextColumn::make('lokasi_foto')
                    ->label('Media Pendukung')
                    ->icon('heroicon-m-photo')
                    ->color('warning')
                    ->formatStateUsing(fn($state) => collect($state)->map(fn($path) => basename($path))->implode(', ')),

            ])
            ->actions([
                // TOMBOL DOWNLOAD

             Action::make('download_media')
                    ->label('Download Media')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($record) {
                        // Karena arsip_foto itu array (multiple upload)
                        $files = $record->lokasi_foto;

                        if (empty($files)) {
                            return Notification::make()->title('Gak ada media bro')->danger()->send();
                        }

                        // Kalau cuma 1 file, langsung download
                        if (count($files) === 1) {
                            return response()->download(storage_path('app/public/' . $files[0]));
                        }

                    }),

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
                    ->visible(fn($record) => !empty($record->lokasi_file)),
            ]);
    }
}
