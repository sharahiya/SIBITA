<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run()
    {
        DB::table('dosens')->insert([
            [
                'nip' => '19800101',
                'nama' => 'Dr. Andi Wijaya',
                'bidang' => 'Machine Learning',
                'kuota_bimbingan' => 5,
                'password' => Hash::make('dosen1'),
                'link_wa_group' => 'https://chat.whatsapp.com/group1'
            ],
            [
                'nip' => '19751123',
                'nama' => 'Prof. Sulastri',
                'bidang' => 'Software Engineering',
                'kuota_bimbingan' => 3,
                'password' => Hash::make('dosen2'),
                'link_wa_group' => 'https://chat.whatsapp.com/group2'
            ],
            [
                'nip' => '19901212',
                'nama' => 'Ir. Rudi Santoso',
                'bidang' => 'Data Science',
                'kuota_bimbingan' => 4,
                'password' => Hash::make('dosen3'),
                'link_wa_group' => 'https://chat.whatsapp.com/group3'
            ]
        ]);
    }
}
