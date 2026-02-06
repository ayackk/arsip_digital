<?php

namespace App\Filament\Admin\Resources\TempatPenyimpanans\Pages;

use App\Filament\Admin\Resources\TempatPenyimpanans\TempatPenyimpananResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTempatPenyimpanan extends EditRecord
{
    protected static string $resource = TempatPenyimpananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
