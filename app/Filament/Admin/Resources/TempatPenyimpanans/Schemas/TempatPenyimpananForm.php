<?php

namespace App\Filament\Admin\Resources\TempatPenyimpanans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class TempatPenyimpananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
                    TextInput::make('nama_ruangan')
                        ->label('Nama Ruangan')
                        ->required(),

                    Select::make('opd_id')
                        ->relationship('opd', 'nama_opd')
                        ->default(Auth::user()->opd_id) // Isi otomatis OPD si login
                        ->required()
                        ->disabled(fn () => Auth::user()->role === 'operator')
                        ->dehydrated(),

                    Grid::make(3)
                        ->schema([
                           TextInput::make('posisi_lemari')
                                ->label('Lemari'),
                           TextInput::make('posisi_rak')
                                ->label('Rak'),
                           TextInput::make('baris')
                                ->label('Baris'), // Kolom tambahan baru
                        ]),
                ]);
    }
}
