<?php

namespace App\Filament\Admin\Resources\Arsips\Pages;

use App\Filament\Admin\Resources\Arsips\ArsipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArsip extends EditRecord
{
    protected static string $resource = ArsipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
