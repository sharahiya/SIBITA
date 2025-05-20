<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengajuans')->insert([
            [
                'id_mahasiswa' => 1,
                'id_dosen_1' => 1,
                'id_dosen_2' => 2,
                'topik_ta' => 'Klasifikasi Citra',
                'deskripsi_ta' => 'Pengembangan model CNN untuk klasifikasi daun.',
                'status' => 'proses',
                'bidang' => 'GIS',
                'tanggal_pengajuan' => now()
            ],
            [
                'id_mahasiswa' => 2,
                'id_dosen_1' => 2,
                'id_dosen_2' => 1,
                'topik_ta' => 'Sistem Pakar Diagnosa Penyakit',
                'deskripsi_ta' => 'Menggunakan forward chaining dan rule-based.',
                'status' => 'diterima',
                'bidang' => 'Data Mining',
                'tanggal_pengajuan' => now()
            ],
            [
                'id_mahasiswa' => 3,
                'id_dosen_1' => 1,
                'id_dosen_2' => 2,
                'topik_ta' => 'Aplikasi Mobile Edukasi',
                'deskripsi_ta' => 'Android app untuk edukasi anak SD.',
                'status' => 'ditolak',
                'bidang' => 'Rekayasa Perangkat Lunak',
                'tanggal_pengajuan' => now()
            ]
        ]);
    }
}
