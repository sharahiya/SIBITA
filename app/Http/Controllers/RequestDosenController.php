<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        $pengajuans = Pengajuan::with('mahasiswa')
        ->where(function ($query) use ($dosen) {
            $query->where('id_dosen', $dosen->id_dosen);
        })
        ->whereIn('status', ['menunggu', 'pending', 'diproses', 'diajukan'])
        ->get()
        ->map(function ($pengajuan) {
            $pengajuan->tipe_pengajuan = 'bimbingan';
            $pengajuan->id_pengajuan = $pengajuan->id_pengajuan;
            return $pengajuan;
        });

        // mendapatkan seluruh anak yang sudah diterima bimbingan
        $mahasiswaTelahDiterimaBimbingan = Pengajuan::with('mahasiswa')
        ->where(function ($query) use ($dosen) {
            $query->where('id_dosen', $dosen->id_dosen);
        })
        ->whereIn('status', ['diterima'])
        ->get();

        // mendapatkan seluruh seminar anak yang sudah diterima bimbingan
        foreach ($mahasiswaTelahDiterimaBimbingan as $pengajuan) {
            $seminars = $pengajuan->mahasiswa->seminars()->where('status', 'pending')->get();
            foreach ($seminars as $seminar) {
            $seminar->tipe_pengajuan = match ($seminar->jenis) {
                'proposal' => 'sempro',
                'hasil' => 'semhas',
                'sidang' => 'sidang',
                default => 'unknown',
            };
            $seminar->id_pengajuan = $pengajuan->id_seminar;
            $pengajuans->push($seminar);
            }
        }

        // Urutkan pengajuans berdasarkan waktu
        $pengajuans = $pengajuans->sortByDesc(function ($item) {
            return $item->created_at;
        })->values();

        return view('requestDosen', compact('pengajuans'));
    }

    public function konfirmasi(Request $request, $id)
{
    $request->validate([
        'aksi' => 'required|in:terima,tolak',
        'alasan' => 'nullable|string|max:255',
    ]);

    $pengajuan = Pengajuan::findOrFail($id);

    if ($pengajuan->status !== 'menunggu') {
        return back()->with('error', 'Pengajuan sudah diproses.');
    }

    if ($request->aksi === 'terima') {
        $pengajuan->status = 'diterima';
        $pengajuan->save();

        // Tangani pembimbing
        $pembimbing = Pembimbing::firstOrNew(['id_mahasiswa' => $pengajuan->id_mahasiswa]);

        if ($pengajuan->dosen_ke == 1) {
            $pembimbing->id_dosen1 = $pengajuan->id_dosen;
        } elseif ($pengajuan->dosen_ke == 2) {
            $pembimbing->id_dosen2 = $pengajuan->id_dosen;
        }

        $pembimbing->save();
    } else {
        $pengajuan->status = 'ditolak';
        $pengajuan->save();

        // Simpan notifikasi penolakan
        Notifikasi::create([
            'id_mahasiswa' => $pengajuan->id_mahasiswa,
            'pesan' => 'Pengajuan Anda ditolak. Alasan: ' . $request->alasan,
            'tanggal_kirim' => now(),
            'status_baca' => 'belum'
        ]);
    }

    return back()->with('success', 'Pengajuan berhasil diperbarui.');
}

    public function updateStatus(Request $request)
{
    $request->validate([
        'id_pengajuan' => 'required',
        'status'       => 'required|in:diterima,ditolak',
        'alasan'       => 'nullable|string|max:255',
    ]);

    $pengajuan = Pengajuan::findOrFail($request->id_pengajuan);

    $pengajuan->status = $request->status;
    $pengajuan->save();

    if ($request->status === 'diterima') {
        // Tangani pembimbing
        $pembimbing = Pembimbing::firstOrNew(['id_mahasiswa' => $pengajuan->id_mahasiswa]);

        if ($pengajuan->dosen_ke == 1) {
            $pembimbing->id_dosen_1 = $pengajuan->id_dosen;
        } elseif ($pengajuan->dosen_ke == 2) {
            $pembimbing->id_dosen_2 = $pengajuan->id_dosen;
        }
        $pembimbing->save();

        // Simpan notifikasi penerimaan
        Notifikasi::create([
            'id_user' => $pengajuan->id_mahasiswa,
            'role' => 'mahasiswa',
            'tipe_notifikasi' => 'Penerimaan Pembimbing',
            'pesan' => 'Pengajuan Anda diterima oleh ' . $pengajuan->dosen->nama . '.',
            'tanggal_kirim' => now(),
            'status_baca' => 'belum',
        ]);

    } elseif ($request->status === 'ditolak') {
        // Simpan notifikasi penolakan
        Notifikasi::create([
            'id_user' => $pengajuan->id_mahasiswa,
            'role' => 'mahasiswa',
            'tipe_notifikasi' => 'Penolakan Pembimbing',
            'pesan' => 'Pengajuan Anda ditolak. Alasan: ' . $request->alasan,
            'tanggal_kirim' => now(),
            'status_baca' => 'belum',
        ]);
    }

    return response()->json(['message' => 'Status pengajuan berhasil diperbarui.']);
}
}
