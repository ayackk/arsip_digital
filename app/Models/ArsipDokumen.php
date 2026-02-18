<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArsipDokumen extends Model
{
    protected $table = 'arsip_dokumen';

    protected $primaryKey = 'id_arsip';
    public $incrementing = true;

    protected $fillable = ['judul_arsip', 'nomor_naskah_dinas', 'tanggal_naskah', 'opd_id', 'unit_pengolah_id', 'jenis_arsip_id', 'penyimpanan_id', 'ringkasan', 'format_file', 'lokasi_file', 'lokasi_foto', 'ukuran_file', 'tingkat', 'tahun_arsip', 'created_by'];

    // Relasi ke Master Data
    public function unitPengolah(): BelongsTo
    {
        return $this->belongsTo(UnitPengolah::class, 'unit_pengolah_id');
    }
    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }
    public function jenisArsip(): BelongsTo
    {
        return $this->belongsTo(JenisArsip::class, 'jenis_arsip_id');
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function penyimpanan(): BelongsTo
    {
        return $this->belongsTo(TempatPenyimpanan::class, 'penyimpanan_id');
    }

    protected static function booted()
    {
        static::saving(function ($arsip) {
            if ($arsip->lokasi_file) {
                // Otomatis isi format file
                $arsip->format_file = pathinfo($arsip->lokasi_file, PATHINFO_EXTENSION);

                // Otomatis isi ukuran file (dalam bytes)
                $filePath = storage_path('app/public/' . $arsip->lokasi_file);
                if (file_exists($filePath)) {
                    $arsip->ukuran_file = filesize($filePath);
                }
            }
        });
    }

    protected $casts = [
        'lokasi_foto' => 'array', // Ini kuncinya bro!
    ];
}
