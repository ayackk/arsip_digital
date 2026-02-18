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
   Schema::create('arsip_dokumen', function (Blueprint $table) {
        $table->id('id_arsip'); // Primary Key sesuai request lo
        $table->string('judul_arsip');
        $table->date('tanggal_naskah');

        // Foreign Keys
        $table->foreignId('unit_pengolah_id')->constrained('unit_pengolah');
        $table->foreignId('jenis_arsip_id')->constrained('jenis_arsip');
        $table->foreignId('penyimpanan_id')->constrained('tempat_penyimpanan');
        $table->foreignId('opd_id')->constrained('opd');

        // Metadata & File
        $table->text('ringkasan')->nullable();
        $table->string('format_file')->nullable();
        $table->integer('ukuran_file')->nullable();
        $table->string('lokasi_file'); // Kolom tambahan untuk simpan path filenya
        $table->string('lokasi_foto')->nullable(); // Kolom tambahan untuk simpan path foto arsip
        $table->enum('tingkat', ['Public', 'Internal', 'Private']); // Kolom untuk tingkat akses

        // Tracker
        $table->foreignId('created_by')->constrained('user');
        $table->timestamps(); // Ini otomatis bikin created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_dokumen');
    }
};
