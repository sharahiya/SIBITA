<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {

        $mahasiswaId = Auth::guard('mahasiswa')->user()->id_mahasiswa;
        $notifikasi = Notifikasi::where('id_user', $mahasiswaId)
            ->where('role', 'mahasiswa')
            ->orderByDesc('tanggal_kirim')
            ->get();

        return view('notifikasi', compact('notifikasi', 'mahasiswaId'));
    }

    public function markAsRead($id, Request $request)
    {
        $notif = Notifikasi::where('id_notifikasi', $id)
            ->firstOrFail();

        $notif->update(['status_baca' => 'dibaca']);

        return response()->json(['success' => true]);
    }
    public function tandaiSatu($id)
    {
        $notif = Notifikasi::where('id_notifikasi', $id)
            ->firstOrFail();

        $notif->update(['status_baca' => 'dibaca']);

        return back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }

    public function tandaiSemua(Request $request)
    {
        Notifikasi::where('id_user', $request->id_user)
            ->where('status_baca', 'belum')
            ->update(['status_baca' => 'dibaca']);

        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca.');
    }

    public function hapusSemua(Request $request)
    {
        Notifikasi::where('id_user', $request->id_user)->delete();

        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }
}
