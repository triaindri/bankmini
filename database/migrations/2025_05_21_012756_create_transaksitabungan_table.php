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
        Schema::create('transaksitabungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tabungan_id')->constrained('tabungan')->onDelete('cascade');
            $table->enum('jenis', ['setor', 'tarik']);
            $table->string('keterangan')->nullable();
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksitabungan');
    }
};
