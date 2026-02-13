<?php

namespace App\Filament\Admin\Resources\Arsips\Pages;

use App\Filament\admin\Resources\Arsips\ArsipResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateArsip extends CreateRecord
{
    protected static string $resource = ArsipResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    // Mengisi kolom created_by dengan ID user yang sedang login
    $data['created_by'] = Auth::id();

    return $data;
}
}
