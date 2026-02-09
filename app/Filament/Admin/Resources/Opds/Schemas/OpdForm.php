<?php

namespace App\Filament\Admin\Resources\Opds\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class OpdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                    TextInput::make('nama_opd')
                        ->label('Nama OPD')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->placeholder('Contoh: Badan Riset dan Inovasi Daerah'),
                ]);
    }
}
