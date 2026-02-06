<?php

namespace App\Filament\Admin\Resources\UnitPengolahs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use filament\Schemas\Components\Section;

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
                ]);
    }
}
