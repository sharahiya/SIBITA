<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run()
    {
        // jurusan informatika id
        $jurusan = DB::table('jurusans')->where('nama_jurusan', 'Informatika')->first();
        $jurusanId = $jurusan ? $jurusan->id : null;
        $fakultasId = DB::table('fakultas')->where('nama_fakultas', 'Fakultas Matematika dan Ilmu Pengetahuan Alam')->first();
        $fakultasId = $fakultasId ? $fakultasId->id : null;
        DB::table('dosens')->insert([
            [
                'nip' => '197202061997021001',
                'nama' => 'Nazaruddin',
                'bidang' => 'Rekayasa Perangkat Lunak',
                'kuota_bimbingan' => 5,
                'password' => Hash::make('dosen1'),
                'id_jurusan' => $jurusanId, // Assuming this is the ID for 'Teknik Informatika'
                'id_fakultas' => $fakultasId, // Assuming this is the ID for 'Fakultas Teknik'
                'link_wa_group' => 'https://chat.whatsapp.com/group1'
            ],
            [
                'nip' => '198806032019031011',
                'nama' => 'Alim Misbullah',
                'bidang' => 'Data Mining',
                'kuota_bimbingan' => 3,
                'id_jurusan' => $jurusanId, // Assuming this is the ID for 'Teknik Informatika'
                'id_fakultas' => $fakultasId, // Assuming this is the ID for 'Fakultas Teknik'
                'password' => Hash::make('dosen2'),
                'link_wa_group' => 'https://chat.whatsapp.com/group2'
            ],
            [
                'nip' => '198806242022031006',
                'nama' => 'Husaini,',
                'bidang' => 'Jaringan',
                'id_jurusan' => 1, // Assuming this is the ID for 'Teknik Informatika'
                'id_fakultas' => 1, // Assuming this is the ID for 'Fakultas Teknik'
                'kuota_bimbingan' => 4,
                'password' => Hash::make('dosen3'),
                'link_wa_group' => 'https://chat.whatsapp.com/group3'
            ],
            [
                'nip' => '198806242022031006',
                'nama' => 'Sri Azizah Nazhifah',
                'bidang' => 'GIS',
                'id_jurusan' => 1, // Assuming this is the ID for 'Teknik Informatika'
                'id_fakultas' => 1, // Assuming this is the ID for 'Fakultas Teknik'
                'kuota_bimbingan' => 6,
                'password' => Hash::make('dosen4'),
                'link_wa_group' => 'https://chat.whatsapp.com/group4'
            ]

        ]);
    }
}
