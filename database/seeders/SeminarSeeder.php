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
                'id_pengajuan' => 1,
                'tanggal_seminar' => now()->addDays(10),
                'status' => 'terjadwal',
                'file_proposal' => 'proposal1.pdf'
            ],
            [
                'id_pengajuan' => 2,
                'tanggal_seminar' => now()->addDays(20),
                'status' => 'belum',
                'file_proposal' => 'proposal2.pdf'
            ],
            [
                'id_pengajuan' => 3,
                'tanggal_seminar' => now()->addDays(5),
                'status' => 'terjadwal',
                'file_proposal' => 'proposal3.pdf'
            ]
        ]);
    }
}
