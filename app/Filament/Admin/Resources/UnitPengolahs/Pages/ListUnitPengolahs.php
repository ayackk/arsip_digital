<?php

namespace App\Filament\Admin\Resources\UnitPengolahs\Pages;

use App\Filament\Admin\Resources\UnitPengolahs\UnitPengolahResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUnitPengolahs extends ListRecords
{
    protected static string $resource = UnitPengolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
