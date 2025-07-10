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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_dosen');
            $table->enum('dosen_ke', [1, 2])->default(1); // Tambah dosen_ke
            $table->string('topik_ta');
            $table->text('deskripsi_ta');
            $table->text('bidang');
            $table->enum('status', ['proses', 'diterima', 'ditolak', 'pending', 'cancelled'])->default('pending');
            $table->text('alasan_ditolak')->nullable();
            $table->date('tanggal_pengajuan');
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('id_dosen')->references('id_dosen')->on('dosens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
