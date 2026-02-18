<?php

namespace App\Filament\Admin\Resources\Arsips\Pages;

use App\Filament\Admin\Resources\Arsips\ArsipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EditArsip extends EditRecord
{
    protected static string $resource = ArsipResource::class;

    // 1. Mencegah Pegawai nembak URL edit secara manual
    public function mount(int | string $record): void
    {
        parent::mount($record);

        if (auth::user()->role === 'pegawai') {
            Notification::make()
                ->title('Akses Ditolak')
                ->body('Pegawai tidak diizinkan mengubah data.')
                ->danger()
                ->send();

            $this->redirect($this->getResource()::getUrl('index'));
        }
    }

    // 2. Menghilangkan tombol Delete di halaman Edit
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => in_array(auth::user()->role, ['admin', 'operator'])),
        ];
    }
}
