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
        Schema::create('siswa_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained('badges')->cascadeOnDelete();
            $table->foreignId('analisis_perilaku_menabung_id')
                ->nullable()
                ->constrained('analisis_perilaku_menabung')
                ->nullOnDelete();
            $table->timestamp('diperoleh_pada');
            $table->timestamps();

            // Cegah badge yang sama diberikan dobel untuk analisis yang sama persis
            $table->unique(['siswa_id', 'badge_id', 'analisis_perilaku_menabung_id'], 'siswa_badge_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_badges');
    }
};
