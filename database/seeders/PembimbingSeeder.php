<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua mahasiswa unik dari pengajuan yang diterima
        $mahasiswaIds = DB::table('pengajuans')
            ->where('status', 'diterima')
            ->pluck('id_mahasiswa')
            ->unique();

        foreach ($mahasiswaIds as $id_mahasiswa) {
            $pengajuanDiterima = DB::table('pengajuans')
                ->where('id_mahasiswa', $id_mahasiswa)
                ->where('status', 'diterima')
                ->get();

            $dosen1 = null;
            $dosen2 = null;

            foreach ($pengajuanDiterima as $pengajuan) {
                if ($pengajuan->dosen_ke == 1) {
                    $dosen1 = $pengajuan->id_dosen;
                } elseif ($pengajuan->dosen_ke == 2) {
                    $dosen2 = $pengajuan->id_dosen;
                }
            }

            // Simpan ke tabel pembimbing
            DB::table('pembimbings')->insert([
                'id_mahasiswa' => $id_mahasiswa,
                'id_dosen_1' => $dosen1,
                'id_dosen_2' => $dosen2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
