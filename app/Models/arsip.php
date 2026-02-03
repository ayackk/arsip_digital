<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arsip extends Model
{
    use HasFactory;

    // Nama tabel di database lo
    protected $table = 'arsip';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'nama_file',
        'file_path',
        'kategori',
    ];

    /**
     * Relasi ke model User
     * Menghubungkan user_id di tabel arsip ke id di tabel user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
