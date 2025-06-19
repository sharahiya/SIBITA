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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id('id_dosen');
            $table->string('nip', 18)->unique();
            $table->string('nama');
            $table->string('bidang');
            $table->string('jabatan')->nullable();
            $table->integer('kuota_bimbingan')->default(0);
            $table->string('password');
            $table->string('link_wa_group')->nullable();
            $table->foreignId('id_jurusan')->constrained('jurusans')->onDelete('cascade');
            $table->foreignId('id_fakultas')->constrained('fakultas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
