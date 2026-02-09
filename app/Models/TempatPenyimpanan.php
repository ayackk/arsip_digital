<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TempatPenyimpanan extends Model
{
    protected $table = 'tempat_penyimpanan';
    protected $fillable = ['nama_ruangan', 'posisi_lemari', 'posisi_rak','baris', 'opd_id'];

    public function opd(): BelongsTo { return $this->belongsTo(Opd::class, 'opd_id'); }
}
