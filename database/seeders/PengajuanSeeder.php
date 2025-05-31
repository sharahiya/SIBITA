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
                'id_dosen' => 1,
                'dosen_ke' => 1,
                'topik_ta' => 'Klasifikasi Citra',
                'deskripsi_ta' => 'Pengembangan model CNN untuk klasifikasi daun.',
                'bidang' => 'GIS',
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_mahasiswa' => 1,
                'id_dosen' => 2,
                'dosen_ke' => 2,
                'topik_ta' => 'Klasifikasi Citra',
                'deskripsi_ta' => 'Pengembangan model CNN untuk klasifikasi daun.',
                'bidang' => 'GIS',
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_mahasiswa' => 2,
                'id_dosen' => 2,
                'dosen_ke' => 1,
                'topik_ta' => 'Sistem Pakar Diagnosa Penyakit',
                'deskripsi_ta' => 'Menggunakan forward chaining dan rule-based.',
                'bidang' => 'Data Mining',
                'status' => 'diterima',
                'tanggal_pengajuan' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_mahasiswa' => 2,
                'id_dosen' => 1,
                'dosen_ke' => 2,
                'topik_ta' => 'Sistem Pakar Diagnosa Penyakit',
                'deskripsi_ta' => 'Menggunakan forward chaining dan rule-based.',
                'bidang' => 'Data Mining',
                'status' => 'diterima',
                'tanggal_pengajuan' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_mahasiswa' => 3,
                'id_dosen' => 1,
                'dosen_ke' => 1,
                'topik_ta' => 'Aplikasi Mobile Edukasi',
                'deskripsi_ta' => 'Android app untuk edukasi anak SD.',
                'bidang' => 'Rekayasa Perangkat Lunak',
                'status' => 'ditolak',
                'tanggal_pengajuan' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_mahasiswa' => 3,
                'id_dosen' => 2,
                'dosen_ke' => 2,
                'topik_ta' => 'Aplikasi Mobile Edukasi',
                'deskripsi_ta' => 'Android app untuk edukasi anak SD.',
                'bidang' => 'Rekayasa Perangkat Lunak',
                'status' => 'ditolak',
                'tanggal_pengajuan' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
