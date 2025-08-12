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
        Schema::create('penilaian_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->string('nama_siswa');
            $table->string('jenis');
            $table->string('kategori');
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->integer('poin')->default(0);
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('data_siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_siswa');
    }
};
