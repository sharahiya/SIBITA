<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PengujiAdminController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();

    // Ambil semua dosen untuk ditampilkan sebagai calon penguji
    $dosenList = Dosen::all();
    return view('pengujiadmin', compact('mahasiswa', 'dosenList'));
    }

    public function show(Request $request, $id){
        // Ambil satu mahasiswa (misalnya berdasarkan ID atau status)

        // ambil id dari parameter URL

    $mahasiswa = Mahasiswa::with(['dospem1', 'dospem2'])->where('id_mahasiswa', $id)->first();

    // Ambil semua dosen untuk ditampilkan sebagai calon penguji
    $dosenList = Dosen::all();
    dd($mahasiswa);
    return view('pengujiadmin', compact('mahasiswa', 'dosenList'));
    }
}
