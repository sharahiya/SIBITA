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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->string('npm')->unique();
            $table->string('email')->default('sharahiya@mhs.usk.ac.id');
            $table->string('nama');
            $table->string('password');
            $table->year('angkatan');
            $table->unsignedBigInteger('id_dosen_wali')->nullable();
            $table->timestamps();

            $table->foreign('id_dosen_wali')->references('id_dosen')->on('dosens')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
