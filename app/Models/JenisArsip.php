<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisArsip extends Model
{
    protected $table = 'jenis_arsip';
    protected $fillable = ['nama_jenis', 'opd_id'];

    public function opd(): BelongsTo { return $this->belongsTo(Opd::class, 'opd_id'); }
}
