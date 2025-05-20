<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
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
            $query->where('id_dosen_1', $dosen->id_dosen)
                  ->orWhere('id_dosen_2', $dosen->id_dosen);
        })
        ->whereIn('status', ['menunggu', 'pending', 'diproses', 'diajukan'])
        ->get();



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
        } else {
            $pengajuan->status = 'ditolak';
            // Catat alasan penolakan jika disimpan ke field
            // $pengajuan->alasan_penolakan = $request->alasan;
        }

        $pengajuan->save();

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

    // if ($pengajuan->status !== 'menunggu') {
    //     return response()->json(['message' => 'Pengajuan sudah diproses.'], 400);
    // }

    $pengajuan->status = $request->status;
    // Jika kamu ingin menyimpan alasan penolakan:
    // $pengajuan->alasan_penolakan = $request->alasan;
    $pengajuan->save();

    // Simpan notifikasi
    if ($request->status === 'ditolak') {
        Notifikasi::create([
            'id_mahasiswa' => $pengajuan->id_mahasiswa,
            'pesan' => 'Pengajuan Anda ditolak. Alasan: ' . $request->alasan,
            'tanggal_kirim' => now(),
            'status_baca' => false
        ]);
    }

    return response()->json(['message' => 'Status pengajuan berhasil diperbarui.']);
}
}
