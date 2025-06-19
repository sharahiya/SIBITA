<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Pengajuan2Controller extends Controller
{
    public function index()
    {
        $idMahasiswa = Auth::guard('mahasiswa')->user()->id_mahasiswa;
        $pengajuan1 = Pengajuan::where('id_mahasiswa', $idMahasiswa)->where('dosen_ke', 1)->first() ?? null;
        $pengajuan2 = Pengajuan::where('id_mahasiswa', $idMahasiswa)->where('dosen_ke', 2)->first() ?? null;

        return view('pengajuan2', compact('pengajuan1', 'pengajuan2'));
    }
}
