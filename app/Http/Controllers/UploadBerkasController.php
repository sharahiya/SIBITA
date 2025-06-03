<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
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

        $jenis = match ($jenis) {
            'sempro' => 'proposal',
            'semhas' => 'hasil',
            'sidang' => 'sidang',
            default => throw new \Exception('Jenis seminar tidak valid'),
        };

        // notifikasi berkas berhasil diajukan ke  dosen pembimbing 1 dan dosen pembimbing 2
        $dosenPembimbing1 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('dosen_ke', 1)
            ->first()?->dosenPembimbing1;
        $dosenPembimbing2 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('dosen_ke', 2)
            ->first()?->dosenPembimbing2;


        Notifikasi::create([
            'id_user' => $dosenPembimbing1->id_dosen,
            'role' => 'dosen',
            'pesan' => "Mahasiswa {$mahasiswa->nama} telah mengajukan berkas seminar {$jenis}.",
            'tanggal_kirim' => now(),
            'status_baca' => 'belum',
            'tipe_notifikasi' => 'Pengajuan'. $jenis,
        ]);
        Notifikasi::create([
            'id_user' => $dosenPembimbing2->id_dosen,
            'role' => 'dosen',
            'pesan' => "Mahasiswa {$mahasiswa->nama} telah mengajukan berkas seminar {$jenis}.",
            'tanggal_kirim' => now(),
            'status_baca' => 'belum',
            'tipe_notifikasi' => 'Pengajuan'. $jenis,
        ]);


        Seminar::updateOrCreate(
            ['id_mahasiswa' => $mahasiswa->id_mahasiswa, 'jenis' => $jenis],
            ['lampiran' => $path, 'status' => 'pending', 'tanggal_seminar' => now()]
        );

        return back()->with('success', 'Berkas berhasil diunggah.');
    }

}
