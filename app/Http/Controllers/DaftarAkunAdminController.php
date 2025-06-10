<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DaftarAkunAdminController extends Controller
{
    public function index()
    {
        // Ambil data mahasiswa dengan relasi dosen wali
        $mahasiswas = Mahasiswa::with('dosenWali')->get();

        // Ambil data dosen
        $dosens = Dosen::all();

        return view('daftarakunadmin', compact('mahasiswas', 'dosens'));
    }
}
