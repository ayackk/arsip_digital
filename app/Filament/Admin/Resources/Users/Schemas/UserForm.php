<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;
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
                        ->dehydrated(fn ($state) => filled($state))
                        ->revealable(),

                   Select::make('role')
                        ->label('Hak Akses')
                        ->options([
                            'pegawai' => 'Pegawai',
                            'admin' => 'Administrator',
                        ])
                        ->required()
                        ->default('pegawai'),
                ])->columns(2);
    }
}
