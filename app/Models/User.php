<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    // Nama tabel sesuai di database lo
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin', 'pegawai'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke model Arsip
     * Satu user bisa memiliki banyak arsip
     */
    public function arsips(): HasMany
    {
        return $this->hasMany(ArsipDokumen::class, 'created_by', 'id');
    }

    /**
     * Syarat user bisa login ke Filament
     * Kita izinkan semua user yang ada di tabel user untuk login
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Lo bisa modifikasi ini jika hanya role tertentu yang boleh login
        return true;
    }
}
