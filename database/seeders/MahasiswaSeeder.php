<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('mahasiswas')->insert([
            [
                'npm' => '2008107010082',
                'email' => 'sharahiya@mhs.usk.ac.id',
                'nama' => 'Shyva Hazainu',
                'password' => Hash::make('password'),
                'angkatan' => 2020,
                'id_dosen_wali' => 1
            ],
            [
                'npm' => '2108107010040',
                'email' => 'sharahiya@mhs.usk.ac.id',
                'nama' => 'Tyara Rayna',
                'password' => Hash::make('password'),
                'angkatan' => 2021,
                'id_dosen_wali' => 1
            ],
            [
                'npm' => '2208107010050',
                'email' => 'sharahiya@mhs.usk.ac.id',
                'nama' => 'Azzariyat Azra',
                'password' => Hash::make('password'),
                'angkatan' => 2022,
                'id_dosen_wali' => 2
            ]
        ]);
    }
}

