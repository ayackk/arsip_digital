<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatPenyimpanan extends Model
{
    protected $table = 'tempat_penyimpanan';
    protected $fillable = ['nama_ruangan', 'posisi_lemari', 'posisi_rak','baris'];
}
