<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TingkatAkses extends Model
{
    protected $table = 'tingkat_akses';
    protected $fillable = ['nama_tingkat', 'opd_id'];

    public function opd(): BelongsTo { return $this->belongsTo(Opd::class, 'opd_id'); }
}
