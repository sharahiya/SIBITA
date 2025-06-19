<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = [
            'Fakultas Ekonomi dan Bisnis' => [
            'Akuntansi Perpajakan',
            'Akuntansi',
            'Manajemen Perusahaan',
            'Sekretari',
            'Keuangan dan Perbankan',
            'Ekonomi Manajemen',
            'Ekonomi Pembangunan',
            'Ekonomi Islam',
            'Bisnis Digital',
            'Manajemen (Magister dan Doktoral)',
            'Ilmu Ekonomi (Magister dan Doktoral)',
            ],
            'Fakultas Kelautan dan Perikanan' => [
            'Ilmu Kelautan',
            'Budidaya Perairan',
            'Pemanfaatan Sumber Daya Perikanan',
            ],
            'Fakultas Kedokteran Hewan' => [
            'Kesehatan Hewan',
            'Pendidikan Dokter Hewan',
            'Profesi Dokter Hewan (PPDH)',
            'Kesehatan Masyarakat Veteriner (Magister)',
            'Sains Veteriner (Doktoral)',
            ],
            'Fakultas Hukum' => [
            'Ilmu Hukum',
            'Kenotariatan (Magister)',
            ],
            'Fakultas Kedokteran' => [
            'Pendidikan Dokter',
            'Psikologi',
            'Sains Biomedis (Magister)',
            'Kesehatan Masyarakat (Magister)',
            'Ilmu Kedokteran (Doktoral)',
            'Program Pendidikan Dokter Spesialis',
            ],
            'Fakultas Keguruan dan Ilmu Pendidikan' => [
            'Pendidikan Jasmani, Kesehatan, dan Rekreasi',
            'Pendidikan Ekonomi',
            'Pendidikan Guru Pendidikan Anak Usia Dini',
            'Pendidikan Sejarah',
            'Pendidikan Guru Sekolah Dasar',
            'Pendidikan Seni, Drama, Tari, dan Musik',
            'Pendidikan Bahasa Inggris',
            'Pendidikan Bahasa Indonesia',
            'Pendidikan Kewarganegaraan',
            'Pendidikan Fisika',
            'Pendidikan Kimia',
            'Pendidikan Biologi',
            'Pendidikan Kesejahteraan Keluarga',
            'Pendidikan Matematika',
            'Pendidikan Geografi',
            'Bimbingan dan Konseling',
            'Pendidikan Profesi Guru',
            'Pendidikan Olahraga (Magister)',
            'Pendidikan Bahasa Indonesia (Magister)',
            'Pendidikan Bahasa Inggris (Magister)',
            'Pendidikan Biologi (Magister)',
            'Pendidikan IPS (Magister)',
            ],
            'Fakultas Teknik' => [
            'Teknik Sipil',
            'Teknik Listrik',
            'Teknik Mesin',
            'Teknik Pertambangan',
            'Teknik Geologi',
            'Teknik Elektro',
            'Teknik Komputer',
            'Teknik Geofisika',
            'Perencanaan Wilayah dan Kota',
            'Teknik Kimia',
            'Teknik Industri',
            'Arsitektur',
            ],
            'Fakultas Keperawatan' => [
            'Ilmu Keperawatan',
            'Profesi Ners',
            ],
            'Fakultas Ilmu Sosial dan Ilmu Politik' => [
            'Ilmu Politik',
            'Ilmu Komunikasi',
            'Ilmu Pemerintahan',
            ],
            'Fakultas Pertanian' => [
            'Agribisnis',
            'Manajemen Agribisnis',
            'Budidaya Peternakan',
            'Proteksi Tanaman',
            'Teknik Pertanian',
            'Teknologi Hasil Pertanian',
            'Ilmu Tanah',
            'Ilmu Peternakan',
            'Teknologi Industri Pertanian',
            'Ilmu Pertanian',
            ],
            'Fakultas Kedokteran Gigi' => [
            'Pendidikan Dokter Gigi',
            ],
            'Fakultas Matematika dan Ilmu Pengetahuan Alam' => [
            'Biologi',
            'Fisika',
            'Statistika',
            'Matematika',
            'Farmasi',
            'Informatika',
            'Kimia',
            'Manajemen Informatika',
            ],
        ];

        foreach ($jurusan as $fakultas => $programs) {
            $fakultasId = DB::table('fakultas')->where('nama_fakultas', $fakultas)->value('id');
            foreach ($programs as $program) {
            DB::table('jurusans')->insert([
                'id_fakultas' => $fakultasId,
                'nama_jurusan' => $program,
            ]);
            }
        }
    }
}
