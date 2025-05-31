<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeminarSeeder extends Seeder
{
    public function run()
    {
        DB::table('seminars')->insert([
            [
            'id_mahasiswa' => 1,
            'tanggal_seminar' => now()->addDays(10),
            'status' => 'diajukan',
            'lampiran' => 'proposal1.pdf',
            'jenis' => 'proposal'
            ],
            [
            'id_mahasiswa' => 2,
            'tanggal_seminar' => now()->addDays(20),
            'status' => 'diterima',
            'lampiran' => 'proposal2.pdf',
            'jenis' => 'hasil'
            ],
            [
            'id_mahasiswa' => 1,
            'tanggal_seminar' => now()->addDays(5),
            'status' => 'ditolak',
            'lampiran' => 'proposal3.pdf',
            'jenis' => 'hasil'
            ]
        ]);
    }
}
