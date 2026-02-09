<?php

namespace App\Filament\Admin\Resources\JenisArsips\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class JenisArsipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nama_jenis')->required()->maxLength(255),
                Select::make('opd_id')
                    ->relationship('opd', 'nama_opd')
                    ->default(Auth::user()->opd_id) // Isi otomatis OPD si login
                    ->required()
                    ->disabled(fn () => Auth::user()->role === 'operator')
                    ->dehydrated(), // Wajib biar nilainya tetap dikirim ke database
    ]);
    }
}
