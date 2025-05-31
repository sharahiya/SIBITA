<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pembimbings', function (Blueprint $table) {
        $table->id('id_pembimbing');
        $table->unsignedBigInteger('id_mahasiswa');
        $table->unsignedBigInteger('id_dosen_1')->nullable();
        $table->unsignedBigInteger('id_dosen_2')->nullable();
        $table->timestamps();

        $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('mahasiswas')->onDelete('cascade');
        $table->foreign('id_dosen_1')->references('id_dosen')->on('dosens')->onDelete('set null');
        $table->foreign('id_dosen_2')->references('id_dosen')->on('dosens')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbings');
    }
};
