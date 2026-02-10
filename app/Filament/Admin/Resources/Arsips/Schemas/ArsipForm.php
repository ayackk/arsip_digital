<?php

namespace App\Filament\Admin\Resources\Arsips\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Builder;

class ArsipForm
{
public static function configure (Schema $schema): Schema
{
    return $schema->schema([
                TextInput::make('judul_arsip')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('tanggal_naskah')
                    ->required(),

                Select::make('unit_pengolah_id')
                    ->relationship('unitPengolah', 'nama_unit',
                   modifyQueryUsing: fn (Builder $query) => Auth::user()->role === 'admin'
                    ? $query
                    : $query->where('opd_id', Auth::user()->opd_id)
                    )
                    ->required()
                    ->preload()
                    ->searchable(),

                Select::make('opd_id')
                    ->label('Asal OPD')
                    ->relationship('opd', 'nama_opd')
                    ->default(Auth::user() ? Auth::user()->opd_id : null) // Otomatis terisi OPD si user
                    ->disabled(fn () => Auth::user() && Auth::user()->role === 'operator') // Operator gak bisa ganti-ganti
                    ->dehydrated() // Tetap simpan nilai ke database meskipun di-disable
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('jenis_arsip_id')
                    ->relationship('jenisArsip', 'nama_jenis',
                    modifyQueryUsing: fn (Builder $query) => Auth::user()->role === 'admin'
                    ? $query
                    : $query->where('opd_id', Auth::user()->opd_id)
                    )
                    ->required()
                    ->preload(),

                Select::make('penyimpanan_id')
                    ->label('Tempat Penyimpanan')
                    ->relationship(
                        name: 'penyimpanan',
                        titleAttribute: 'nama_ruangan',
                        modifyQueryUsing: fn (Builder $query) => Auth::user()->role === 'admin'
                        ? $query
                        : $query->where('opd_id', Auth::user()->opd_id)
                )
                    ->getOptionLabelFromRecordUsing(fn ($record) =>
                        "{$record->nama_ruangan} | Lemari {$record->posisi_lemari} | Rak {$record->posisi_rak} | Baris {$record->baris}"
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('ringkasan')
                    ->rows(3)
                    ->columnSpanFull(),

                FileUpload::make('lokasi_file')
                    ->label('Dokumen Digital (PDF)')
                    ->directory('arsip-digital')
                    ->disk('public')
                    ->required()
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Untuk .docx
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' // Untuk .xlsx'
                    ])
                    ->preserveFilenames() // Opsional: biar nama filenya gak jadi kode acak
                    // Hapus Type Hinting (TemporaryUploadedFile) biar nggak error
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Cek apakah $state adalah objek file sementara
                        if ($state instanceof UploadedFile) {
                            // Ambil ekstensi asli dari nama file user (bukan nama sistem tmp)
                            $extension = $state->getClientOriginalExtension();
                            $set('format_file', $extension);
                        }
                    })
                    ->reactive(),

                TextInput::make('format_file')
                    ->label('Format File')
                    ->default('')
                    ->readOnly(),

                // Hidden fields untuk metadata
                Hidden::make('format_file'),
                Hidden::make('created_by')
                    ->default(Auth::user() ? Auth::user()->id : null),
            ]);
}
}
