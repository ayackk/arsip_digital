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
    // public function mount(int | string $record): void
    // {
    //     $user = auth::user();
    //     $recordData = $this->getRecord(); // Ambil data arsip yang mau diedit

    //     if ($user->role === 'pegawai') {
    //     // Cek: Apakah ini miliknya DAN apakah statusnya Private?
    //     // Catatan: Pastikan kolom di DB namanya 'tingkat' dan isinya 'Private'
    //     $isOwner = $recordData->created_by === $user->id;
    //     $isPrivate = $recordData->tingkat === 'Private';

    //     if (!($isOwner && $isPrivate)) {
    //         Notification::make()
    //             ->title('Akses Ditolak')
    //             ->body('Anda hanya boleh mengubah arsip Private milik sendiri.')
    //             ->danger()
    //             ->send();

    //         $this->redirect($this->getResource()::getUrl('index'));
    //         }
    //     }
    // }

    // 2. Menghilangkan tombol Delete di halaman Edit
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(function ($record) {
                $user = auth::user();

                if (in_array($user->role, ['admin', 'operator'])) {
                    return true;
                }

                // Logika yang sama: Milik sendiri & statusnya Rahasia
                return $record->created_by === $user->id && $record->tingkat === 'Private';
            }),
        ];
    }
}
