<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pengajuan;
use App\Models\PengajuanSeminar;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadBerkasController extends Controller
{
    public function index()
{
    $mahasiswa = Auth::guard('mahasiswa')->user();

    // Ambil semua seminar berdasarkan jenis dengan pengajuan seminarnya
    $sempro = Seminar::with(['pengajuanSeminar' => function($query) {
        $query->with('dosen');
    }])
    ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
    ->where('jenis', 'proposal')
    ->first();

    $semhas = Seminar::with(['pengajuanSeminar' => function($query) {
        $query->with('dosen');
    }])
    ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
    ->where('jenis', 'hasil')
    ->first();

    $sidang = Seminar::with(['pengajuanSeminar' => function($query) {
        $query->with('dosen');
    }])
    ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
    ->where('jenis', 'sidang')
    ->first();

    $pengajuan = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
        ->latest()
        ->first();

    $dospem1 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
        ->where('dosen_ke', 1)
        ->first()?->dosenPembimbing1;

    $dospem2 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
        ->where('dosen_ke', 2)
        ->first()?->dosenPembimbing2;

    $pengajuanSeminar = PengajuanSeminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
        ->get();



    return view('uploadberkas', compact('mahasiswa', 'sempro', 'semhas', 'sidang', 'dospem1', 'dospem2', 'pengajuan', 'pengajuanSeminar'));
}
public function upload(Request $request)
{
    $mahasiswa = Auth::guard('mahasiswa')->user();
    $jenis = $request->jenis;

    // Validate sequential upload
    if ($jenis === 'semhas') {
        $sempro = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('jenis', 'proposal')
            ->where('status', 'diterima')
            ->first();

        if (!$sempro) {
            return back()->with('error', 'Anda harus menyelesaikan seminar proposal terlebih dahulu.');
        }
    }

    if ($jenis === 'sidang') {
        // commit baru
        $semhas = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('jenis', 'hasil')
            ->where('status', 'diterima')
            ->first();

        if (!$semhas) {
            return back()->with('error', 'Anda harus menyelesaikan seminar hasil terlebih dahulu.');
        }
    }

    // Validate the request
    $request->validate([
        'berkas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Get both supervisors
    $dospem1 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
        ->where('dosen_ke', 1)
        ->first()?->dosen;
    $dospem2 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
        ->where('dosen_ke', 2)
        ->first()?->dosen;

    if (!$dospem1 || !$dospem2) {
        return back()->with('error', 'Data dosen pembimbing tidak lengkap.');
    }

    // Store the file
    $path = $request->file('berkas')->store('uploads/berkas', 'public');

    // Map seminar type
    $jenis = match ($jenis) {
        'sempro' => 'proposal',
        'semhas' => 'hasil',
        'sidang' => 'sidang',
        default => throw new \Exception('Jenis seminar tidak valid'),
    };

    // Create or update seminar record
    $seminar = Seminar::updateOrCreate(
        ['id_mahasiswa' => $mahasiswa->id_mahasiswa, 'jenis' => $jenis],
        [
            'lampiran' => $path,
            'status' => 'pending',
            'tanggal_seminar' => now()
        ]
    );

    // Create or update pengajuan seminar for both supervisors
    foreach ([$dospem1, $dospem2] as $index => $dosen) {
        $pengajuanSeminar = PengajuanSeminar::where('id_dosen', $dosen->id_dosen)
            ->where('id_seminar', $seminar->id_seminar)
            ->first();

        if ($pengajuanSeminar) {
            // Update only if status is pending or rejected
            if (in_array($pengajuanSeminar->status, ['pending', 'ditolak'])) {
                $pengajuanSeminar->update([
                    'status' => 'pending',
                    'tanggal_pengajuan' => now(),
                ]);
            }
        } else {
            // Create new pengajuan seminar
            PengajuanSeminar::create([
                'id_seminar' => $seminar->id_seminar,
                'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                'id_dosen' => $dosen->id_dosen,
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
            ]);
        }
    }

    // Create notifications for both supervisors
    foreach ([$dospem1, $dospem2] as $index => $dosen) {
        Notifikasi::create([
            'id_user' => $dosen->id_dosen,
            'role' => 'dosen',
            'pesan' => "Mahasiswa {$mahasiswa->nama} telah mengajukan berkas seminar {$jenis}.",
            'tanggal_kirim' => now(),
            'status_baca' => 'belum',
            'tipe_notifikasi' => 'Pengajuan ' . ucfirst($jenis)
        ]);
    }

    return back()->with('success', 'Berkas berhasil diunggah dan menunggu persetujuan kedua dosen pembimbing.');
}

}
