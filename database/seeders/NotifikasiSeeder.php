<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotifikasiSeeder extends Seeder
{
    public function run()
    {
        DB::table('notifikasis')->insert([
            [
                'id_mahasiswa' => 1,
                'pesan' => 'Pengajuan TA kamu sedang diproses.',
                'tanggal_kirim' => now(),
                'status_baca' => 'belum'
            ],
            [
                'id_mahasiswa' => 2,
                'pesan' => 'Pengajuan TA kamu diterima.',
                'tanggal_kirim' => now()->subDay(),
                'status_baca' => 'dibaca'
            ],
            [
                'id_mahasiswa' => 3,
                'pesan' => 'Pengajuan TA kamu ditolak. Silakan ajukan ulang.',
                'tanggal_kirim' => now()->subDays(2),
                'status_baca' => 'belum'
            ]
        ]);
    }
}
