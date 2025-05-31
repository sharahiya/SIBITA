<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadBerkasController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Ambil semua seminar berdasarkan jenis
        $sempro = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('jenis', 'proposal')->first();
        $semhas = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('jenis', 'hasil')->first();
        $sidang = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('jenis', 'sidang')->first();

        $pengajuan = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->latest()->first();

        // dd($mahasiswa->pembimbing);

        $dospem1 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('dosen_ke', 1)
            ->first()?->dosenPembimbing1;
        $dospem2 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('dosen_ke', 2)
            ->first()?->dosenPembimbing2;

        return view('uploadberkas', compact('mahasiswa', 'sempro', 'semhas', 'sidang', 'dospem1', 'dospem2', 'pengajuan'));
    }

    public function upload(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $jenis = $request->jenis;

        // Cek apakah sudah pernah upload
        $seminar = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                    ->where('jenis', $jenis)
                    ->first();

        if ($seminar && $seminar->lampiran && $seminar->status !== 'ditolak') {
            return back()->with('error', 'Berkas sudah diunggah sebelumnya.');
        }

        $request->validate([
            'berkas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('berkas')->store('uploads/berkas', 'public');

        // Simpan ke DB
        Seminar::updateOrCreate(
            ['id_mahasiswa' => $mahasiswa->id_mahasiswa, 'jenis' => $jenis],
            ['lampiran' => $path, 'status' => 'pending', 'tanggal_seminar' => now()]
        );

        return back()->with('success', 'Berkas berhasil diunggah.');
    }

}
