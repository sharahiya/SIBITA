<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeminarController extends Controller
{

public function updateStatus(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
        'status' => 'required|in:diterima,ditolak',
        'alasan' => 'nullable|string|max:255',
    ]);

    $seminar = Seminar::findOrFail($request->id);
    $seminar->status = $request->status;
    $seminar->save();

    // Simpan notifikasi jika perlu
    Notifikasi::create([
        'id_user' => $seminar->id_mahasiswa,
        'role' => 'mahasiswa',
        'tipe_notifikasi' => $request->status === 'diterima' ? 'Persetujuan Seminar' : 'Penolakan Seminar',
        'pesan' => $request->status === 'diterima'
            ? "Pengajuan seminar Anda telah disetujui oleh dosen."
            : "Pengajuan seminar Anda ditolak. Alasan: " . $request->alasan,
        'tanggal_kirim' => now(),
        'status_baca' => 'belum',
    ]);

    return response()->json(['message' => 'Status seminar berhasil diperbarui.']);
}
}
