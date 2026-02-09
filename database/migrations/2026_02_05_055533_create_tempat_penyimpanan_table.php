<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tempat_penyimpanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan'); // Contoh: Gedung A, Ruang 01
            $table->string('posisi_lemari'); // Contoh: Rak 5
            $table->string('posisi_rak'); // Contoh: TA-001
            $table->string('baris'); // Contoh: Laci 3
            $table->foreignId('opd_id')->nullable()->constrained('opd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempat_penyimpanan');
    }
};
