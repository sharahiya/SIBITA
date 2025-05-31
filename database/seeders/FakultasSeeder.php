<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fakultas')->insert([
            ['nama_fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama_fakultas' => 'Fakultas Kelautan dan Perikanan'],
            ['nama_fakultas' => 'Fakultas Kedokteran Hewan'],
            ['nama_fakultas' => 'Fakultas Hukum'],
            ['nama_fakultas' => 'Fakultas Kedokteran'],
            ['nama_fakultas' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['nama_fakultas' => 'Fakultas Teknik'],
            ['nama_fakultas' => 'Fakultas Keperawatan'],
            ['nama_fakultas' => 'Fakultas Ilmu Sosial dan Ilmu Politik'],
            ['nama_fakultas' => 'Fakultas Pertanian'],
            ['nama_fakultas' => 'Fakultas Kedokteran Gigi'],
            ['nama_fakultas' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam'],
        ]);
    }
}
