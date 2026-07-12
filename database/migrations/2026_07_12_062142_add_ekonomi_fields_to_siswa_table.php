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
        Schema::table('siswa', function (Blueprint $table) {
            $table->decimal('pendapatan_orang_tua', 15, 2)->nullable()->after('telepon');
            $table->unsignedTinyInteger('jumlah_tanggungan')->nullable()->after('pendapatan_orang_tua');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['pendapatan_orang_tua', 'jumlah_tanggungan']);
        });
    }
};
