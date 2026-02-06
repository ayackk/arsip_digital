<?php

namespace App\Filament\Admin\Resources\JenisArsips\Pages;

use App\Filament\Admin\Resources\JenisArsips\JenisArsipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenisArsip extends EditRecord
{
    protected static string $resource = JenisArsipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
