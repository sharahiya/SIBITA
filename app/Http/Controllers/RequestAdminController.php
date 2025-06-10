<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\Penguji;
use Illuminate\Http\Request;

class RequestAdminController extends Controller
{
    public function index()
    {
        $students = Pembimbing::whereNotNull('id_dosen_1')
            ->whereNotNull('id_dosen_2')
            ->get();


        $students = $students->map(function ($student) {
            $pengajuan = $student->mahasiswa->pengajuan()->first();
            $penguji1 = Penguji::where('id_mahasiswa', $student->id_mahasiswa)
                ->where('urutan', '1')
                ->first();

            $penguji2 = Penguji::where('id_mahasiswa', $student->id_mahasiswa)
                ->where('urutan', '2')
                ->first();
            return [
                'id_mahasiswa' => $student->id_mahasiswa,
                'nama' => $student->mahasiswa->nama,
                'npm' => $student->mahasiswa->npm,
                'dosen_1' => $student->dosen1->nama ?? null,
                'dosen_2' => $student->dosen2->nama ?? null,
                'bidang' => $pengajuan->bidang ?? null,
                'judul' => $pengajuan->topik_ta ?? null,
                'penguji_1' => $penguji1 ? $penguji1 : null,
                'penguji_2' => $penguji2 ? $penguji2 : null,
            ];
        });
        return view('requestadmin', ['students' => $students]);
        return view('requestadmin');
    }
}
