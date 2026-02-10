<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'role', // 'admin','operator','pegawai'
        'opd_id',
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
     * Relasi ke model OPD
     * Satu user bisa memiliki satu OPD
     */
    public function opd(): BelongsTo { return $this->belongsTo(Opd::class, 'opd_id'); }

    /**
     * Syarat user bisa login ke Filament
     * Kita izinkan semua user yang ada di tabel user untuk login
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Berikan izin akses ke panel admin hanya untuk role admin dan operator
        return in_array($this->role, ['admin', 'operator']);
    }
}
