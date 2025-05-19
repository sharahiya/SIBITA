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
                'npm' => '200001',
                'email' => 'mahasiswa1@example.com',
                'nama' => 'Ahmad Ramadhan',
                'password' => Hash::make('password'),
                'angkatan' => 2020,
                'id_dosen_wali' => 1
            ],
            [
                'npm' => '200002',
                'email' => 'mahasiswa2@example.com',
                'nama' => 'Siti Aminah',
                'password' => Hash::make('password'),
                'angkatan' => 2021,
                'id_dosen_wali' => 1
            ],
            [
                'npm' => '200003',
                'email' => 'mahasiswa3@example.com',
                'nama' => 'Budi Pratama',
                'password' => Hash::make('password'),
                'angkatan' => 2022,
                'id_dosen_wali' => 2
            ]
        ]);
    }
}

