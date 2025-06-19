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
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_user');
            $table->string('role'); // bisa: 'mahasiswa', 'dosen', 'admin', dst
            $table->string('tipe_notifikasi')->nullable(); // misalnya: 'pengajuan_ta', 'jadwal_kuliah', 'pengumuman', dst
            $table->text('pesan');
            $table->dateTime('tanggal_kirim')->default(now());
            $table->enum('status_baca', ['dibaca', 'belum'])->default('belum');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
