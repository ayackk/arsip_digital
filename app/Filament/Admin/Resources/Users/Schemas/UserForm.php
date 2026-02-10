<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
                   TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),

                   TextInput::make('email')
                        ->label('Alamat Email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                   TextInput::make('password')
                        ->label('Password')
                        ->password()
                        // Password hanya wajib diisi saat buat user baru
                        ->required(fn (string $context): bool => $context === 'create')
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->revealable(),

                    Select::make('opd_id')
                        ->label('Asal OPD')
                        ->relationship('opd', 'nama_opd')
                        ->default(Auth::user() ? Auth::user()->opd_id : null) // Otomatis terisi OPD si user
                        ->disabled(fn () => Auth::user() && Auth::user()->role === 'operator') // Operator gak bisa ganti-ganti
                        ->dehydrated() // Tetap simpan nilai ke database meskipun di-disable
                        ->searchable()
                        ->preload()
                        ->required(),

                   Select::make('role')
                        ->label('Hak Akses')
                        ->options(function () {
                        $user = Auth::user();

                        // Kalau yang login Admin, dia bisa buat semua role
                        if ($user->role === 'admin') {
                            return [
                                'admin' => 'Admin',
                                'operator' => 'Operator',
                                'pegawai' => 'Pegawai',
                            ];
                        }

                        // Kalau yang login Operator, cuma muncul pilihan Pegawai
                        return [
                            'pegawai' => 'Pegawai',
                        ];
                    })
                    ->required()
                    ->native(false),
                ])->columns(2);
    }
}
