<?php

namespace App\Filament\Resources\Arsips\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Auth;
use filament\Schemas\Components\Section;

class ArsipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
                Section::make('Unggah Dokumen Baru')
                    ->schema([
                        TextInput::make('nama_file')
                            ->required(),

                        Select::make('kategori')
                            ->options([
                                'Surat Masuk' => 'Surat Masuk',
                                'Surat Keluar' => 'Surat Keluar',
                                'Laporan' => 'Laporan',
                            ])
                            ->required(),

                        FileUpload::make('file_path')
                            ->label('File Dokumen')
                            ->directory('arsip-digital')
                            ->required(),

                        Hidden::make('user_id')
                            ->default(fn () => Auth::id()),
                    ])
            ]);
    }
}
