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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id('id_seminar');
            $table->unsignedBigInteger('id_mahasiswa');
            $table->date('tanggal_seminar')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->string('lampiran')->nullable()->default(null);
            $table->string('jenis');
            $table->decimal('nilai', 5, 2)->nullable()->default(null); // Nullable for seminars without grades
            $table->integer('lulus')->default(0); // Default to false, can be updated later
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('mahasiswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
