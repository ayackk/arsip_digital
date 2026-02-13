<?php

namespace App\Filament\Admin\Resources\TingkatAkses\Pages;

use App\Filament\Admin\Resources\TingkatAkses\TingkatAksesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTingkatAkses extends ListRecords
{
    protected static string $resource = TingkatAksesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
