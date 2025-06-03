<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Penguji;
use Illuminate\Http\Request;

class PengujiAdminController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();

    // Ambil semua dosen untuk ditampilkan sebagai calon penguji
    $dosenList = Dosen::whereHas('jurusan', function ($query) {
        $query->where('nama_jurusan', 'informatika');
    })->get();
        $pengajuan = $mahasiswa->pengajuan()->first();

        // cek apakah ada penguji urutan 1 dan 2
        $penguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 1)->first();
        $penguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 2)->first();
    return view('pengujiadmin', compact('mahasiswa', 'dosenList','pengajuan', 'penguji1', 'penguji2'));
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


    public function store(Request $request, Mahasiswa $mahasiswa)
{
    $request->validate([
        'penguji_1' => 'required',
        'penguji_2' => 'required',
    ]);

    // Cek apakah sudah ada penguji sebelumnya, hapus jika perlu
    Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->delete();

    // Cari dosen berdasarkan nama
    $dosen1 = Dosen::where('nama', $request->penguji_1)->first();
    $dosen2 = Dosen::where('nama', $request->penguji_2)->first();

    // Simpan penguji
    Penguji::create([
        'id_mahasiswa' => $mahasiswa->id_mahasiswa,
        'id_dosen' => $dosen1->id_dosen,
        'urutan' => 1
    ]);

    Penguji::create([
        'id_mahasiswa' => $mahasiswa->id_mahasiswa,
        'id_dosen' => $dosen2->id_dosen,
        'urutan' => 2
    ]);

    return redirect()->back()->with('success', 'Penguji berhasil ditetapkan.');
}

public function reset(Mahasiswa $mahasiswa)
{
    Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->delete();

    return redirect()->back()->with('success', 'Penguji berhasil direset. Silakan tetapkan ulang.');
}
}
