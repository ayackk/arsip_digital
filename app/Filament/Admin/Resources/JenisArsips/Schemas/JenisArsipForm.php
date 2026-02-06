<?php

namespace App\Filament\Admin\Resources\JenisArsips\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class JenisArsipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nama_jenis')->required()->maxLength(255),
    ]);
    }
}
