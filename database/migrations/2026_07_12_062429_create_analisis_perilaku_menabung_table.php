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
        Schema::create('analisis_perilaku_menabung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->unsignedInteger('frekuensi_menabung');
            $table->decimal('jumlah_setoran', 15, 2);
            $table->decimal('pendapatan_orang_tua', 15, 2);
            $table->unsignedTinyInteger('jumlah_tanggungan');
            $table->decimal('skor', 5, 2);
            $table->enum('kategori', ['Kurang', 'Cukup', 'Baik']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_perilaku_menabung');
    }
};
