<?php

namespace App\Filament\Admin\Resources\UnitPengolahs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class UnitPengolahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
                    TextInput::make('nama_unit')
                        ->label('Nama Unit Pengolah')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->placeholder('Contoh: Bidang Kepegawaian'),
                    Select::make('opd_id')
                        ->relationship('opd', 'nama_opd')
                        ->default(Auth::user()->opd_id) // Isi otomatis OPD si login
                        ->required()
                        ->disabled(fn () => Auth::user()->role === 'operator')
                        ->dehydrated(),
                ]);
    }
}
