<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitPengolah extends Model
{
    protected $table = 'unit_pengolah';
    protected $fillable = ['nama_unit', 'opd_id'];

    public function opd(): BelongsTo { return $this->belongsTo(Opd::class, 'opd_id'); }
}

