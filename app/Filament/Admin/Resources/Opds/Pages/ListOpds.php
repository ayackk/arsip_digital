<?php

namespace App\Filament\Admin\Resources\Opds\Pages;

use App\Filament\Admin\Resources\Opds\OpdResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOpds extends ListRecords
{
    protected static string $resource = OpdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
