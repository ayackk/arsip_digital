<?php

namespace App\Filament\Admin\Resources\TempatPenyimpanans\Pages;

use App\Filament\Admin\Resources\TempatPenyimpanans\TempatPenyimpananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTempatPenyimpanans extends ListRecords
{
    protected static string $resource = TempatPenyimpananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
