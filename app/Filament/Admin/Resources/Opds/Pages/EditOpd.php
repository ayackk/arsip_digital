<?php

namespace App\Filament\Admin\Resources\Opds\Pages;

use App\Filament\Admin\Resources\Opds\OpdResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOpd extends EditRecord
{
    protected static string $resource = OpdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
