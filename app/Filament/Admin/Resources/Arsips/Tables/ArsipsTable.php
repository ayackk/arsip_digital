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
use Filament\Notifications\Notification;

class ArsipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul_arsip')->searchable()->sortable(),
                TextColumn::make('tanggal_naskah')->date()->sortable(),
                TextColumn::make('unitPengolah.nama_unit')->label('Unit'),
                TextColumn::make('jenisArsip.nama_jenis')->label('Kategori'),
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
                // basename() itu buat nampilin nama file doang, gak usah path lengkap
            ])
            ->filters([SelectFilter::make('unit_pengolah_id')->relationship('unitPengolah', 'nama_unit')->label('Filter Unit'), SelectFilter::make('opd_id')->relationship('opd', 'nama_opd')->label('Filter OPD')])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    // Tombol Edit cuma muncul buat admin & operator
                    ->visible(function ($record) {
                    $user = auth::user();

                    // 1. Admin & Operator bebas hapus apa saja
                    if (in_array($user->role, ['admin', 'operator'])) {
                        return true;
                    }

                    // 2. Pegawai cuma bisa hapus kalau itu arsip "Rahasia" miliknya sendiri
                    // Kita cek kolom 'tingkat_id' atau 'tingkat' sesuai database
                    return $record->created_by === $user->id && $record->tingkat === 'Private';
                    }),

                DeleteAction::make()
                // Tombol Delete cuma muncul buat admin & operator
                    ->visible(function ($record) {
                    $user = auth::user();

                    // 1. Admin & Operator bebas hapus apa saja
                    if (in_array($user->role, ['admin', 'operator'])) {
                        return true;
                    }

                    // 2. Pegawai cuma bisa hapus kalau itu arsip "Rahasia" miliknya sendiri
                    // Kita cek kolom 'tingkat_id' atau 'tingkat' sesuai database
                    return $record->created_by === $user->id && $record->tingkat === 'Private';
                    }),

                Action::make('download_media')
                    ->label('Download Media')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($record) {
                        // Karena arsip_foto itu array (multiple upload)
                        $files = $record->lokasi_foto;

                        if (empty($files)) {
                            return Notification::make()->title('Media tidak tersedia')->danger()->send();
                        }

                        // Kalau cuma 1 file, langsung download
                        if (count($files) === 1) {
                            return response()->download(storage_path('app/public/' . $files[0]));
                        }

                    }),

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
                    ->visible(fn($record) => !empty($record->lokasi_file)),

            ])
            ->bulkActions([
                BulkActionGroup::make([
                DeleteBulkAction::make()
                    // Hapus masal juga cuma buat admin & operator
                    ->visible(fn () => in_array(auth::user()->role, ['admin', 'operator'])),
            ]),

                     ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
