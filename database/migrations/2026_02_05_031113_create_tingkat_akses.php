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
        Schema::create('tingkat_akses', function (Blueprint $table) {
            $table->id();
            $table->enum('tingkat', ['Public', 'Internal', 'Private']);
            $table->foreignId('opd_id')->nullable()->constrained('opd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tingkat_akses');
    }
};
