<?php

namespace App\Filament\Admin\Resources\JenisArsips\Pages;

use App\Filament\Admin\Resources\JenisArsips\JenisArsipResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisArsips extends ListRecords
{
    protected static string $resource = JenisArsipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
