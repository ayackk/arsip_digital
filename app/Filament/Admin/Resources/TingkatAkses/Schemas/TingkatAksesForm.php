<?php

namespace App\Filament\Admin\Resources\TingkatAkses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class TingkatAksesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                    TextInput::make('nama_tingkat')
                        ->required()
                        ->placeholder('Contoh: Public, Internal, atau Private')
                        ->maxLength(255),

                    Select::make('opd_id')
                        ->label('Asal OPD')
                        ->relationship('opd', 'nama_opd')
                        ->default(fn () => Auth::user()?->opd_id)
                        ->disabled(fn () => Auth::user()?->role !== 'admin')
                        ->dehydrated()
                        ->required(),
                ]);
    }
}
