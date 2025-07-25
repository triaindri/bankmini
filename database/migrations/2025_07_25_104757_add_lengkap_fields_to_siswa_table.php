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
            $table->string('email')->nullable()->after('jeniskelamin');
            $table->string('telepon')->nullable()->after('email');
            $table->string('tempat_lahir')->nullable()->after('telepon');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['email', 'telepon', 'tempat_lahir', 'tanggal_lahir']);
        });
    }
};
