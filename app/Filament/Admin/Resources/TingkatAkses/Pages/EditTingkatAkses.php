<?php

namespace App\Filament\Admin\Resources\TingkatAkses\Pages;

use App\Filament\Admin\Resources\TingkatAkses\TingkatAksesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTingkatAkses extends EditRecord
{
    protected static string $resource = TingkatAksesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
