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
                'id_user' => 1,
                'pesan' => 'Pengajuan TA kamu diterima.',
                'role' => 'mahasiswa',
                'tipe_notifikasi' => 'Penerimaan Bimbingan',
                'tanggal_kirim' => now(),
                'status_baca' => 'belum'
            ],
            [
                'id_user' => 1,
                'pesan' => 'Pengajuan TA kamu diterima.',
                'role' => 'mahasiswa',
                'tipe_notifikasi' => 'Penerimaan Bimbingan',
                'tanggal_kirim' => now()->subDay(),
                'status_baca' => 'belum'
            ],
            [
                'id_user' =>1,
                'pesan' => 'Pengajuan TA kamu ditolak. Silakan ajukan ulang.',
                'role' => 'mahasiswa',
                'tipe_notifikasi' => 'Penolakan Bimbingan',
                'tanggal_kirim' => now()->subDays(2),
                'status_baca' => 'belum'
            ]
        ]);
    }
}
