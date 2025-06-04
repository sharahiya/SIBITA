<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use App\Models\PengajuanSeminar;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        $pengajuans = Pengajuan::with(['mahasiswa'])
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
            $seminars = $pengajuan->mahasiswa->pengajuanSeminar()->where('status', 'pending')->where('id_dosen', $dosen->id_dosen)->with('seminar')->get();
            foreach ($seminars as $seminar) {
                // dd($seminar->seminar);
            $seminar->tipe_pengajuan = match ($seminar->jenis) {
                'proposal' => 'sempro',
                'hasil' => 'semhas',
                'sidang' => 'sidang',
                default => 'unknown',
            };

            $seminar->status = $seminar->seminar->status;
            $seminar->tanggal_seminar = $seminar->seminar->tanggal_seminar;
            $seminar->lampiran = $seminar->seminar->lampiran;
            $seminar->id_mahasiswa = $pengajuan->id_mahasiswa;
            $seminar->id_dosen = $pengajuan->id_dosen;
            $seminar->tipe_pengajuan = $seminar->seminar->jenis;
            $seminar->id_pengajuan = $pengajuan->id_seminar;
            $seminar->role = $pengajuan->dosen_ke;
            $seminar->bidang = $pengajuan->bidang;
            $seminar->topik_ta = $pengajuan->topik_ta;
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

    $pengajuan = PengajuanSeminar::findOrFail($id);

    if ($pengajuan->status !== 'pending') {
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
        'status' => 'required|in:diterima,ditolak',
        'alasan' => 'nullable|string|max:255',
        'tipe' => 'required|in:bimbingan,proposal,hasil,sidang'
    ]);

    $dosen = Auth::guard('dosen')->user();

    if ($request->tipe === 'bimbingan') {
        return $this->updatePengajuanBimbingan($request);
    }

    // Handle Seminar Request
    $pengajuanSeminar = PengajuanSeminar::where('id_seminar', $request->id_pengajuan)
        ->where('id_dosen', $dosen->id_dosen)
        ->first();

    if (!$pengajuanSeminar) {
        return response()->json(['message' => 'Data pengajuan tidak ditemukan'], 404);
    }

    // Update PengajuanSeminar status
    $pengajuanSeminar->status = $request->status;
    $pengajuanSeminar->catatan = $request->alasan;
    $pengajuanSeminar->save();

    // Get Seminar data
    $seminar = Seminar::find($pengajuanSeminar->id_seminar);

    // Get both supervisors' approval status
    $pengajuanDosen1 = $seminar->getPengajuanDosen1();
    $pengajuanDosen2 = $seminar->getPengajuanDosen2();

    // Update Seminar status if both supervisors have responded
    if ($pengajuanDosen1 && $pengajuanDosen2) {
        if ($pengajuanDosen1->status === 'diterima' && $pengajuanDosen2->status === 'diterima') {
            $seminar->status = 'diterima';
            $notifMessage = "Pengajuan seminar {$request->tipe} Anda telah disetujui oleh kedua dosen pembimbing.";
        }
        else if ($pengajuanDosen1->status === 'ditolak' && $pengajuanDosen2->status === 'ditolak') {
            $seminar->status = 'ditolak';
            $notifMessage = "Pengajuan seminar {$request->tipe} Anda ditolak oleh kedua dosen pembimbing.";
        }
        else if ($pengajuanDosen1->status === 'ditolak' || $pengajuanDosen2->status === 'ditolak') {
            $seminar->status = 'ditolak';
            $notifMessage = "Pengajuan seminar {$request->tipe} Anda ditolak oleh salah satu dosen pembimbing.";
        }
        else {
            $notifMessage = "Status pengajuan seminar {$request->tipe} Anda telah diperbarui oleh {$dosen->nama}.";
        }
        $seminar->save();
    } else {
        $notifMessage = "Status pengajuan seminar {$request->tipe} Anda telah diperbarui oleh {$dosen->nama}.";
    }

    // Create notification for student
    Notifikasi::create([
        'id_user' => $pengajuanSeminar->id_mahasiswa,
        'role' => 'mahasiswa',
        'tipe_notifikasi' => 'Pengajuan ' . ucfirst($request->tipe),
        'pesan' => $notifMessage . ($request->status === 'ditolak' ? " Alasan: {$request->alasan}" : ""),
        'tanggal_kirim' => now(),
        'status_baca' => 'belum'
    ]);

    return response()->json([
        'message' => 'Status pengajuan berhasil diperbarui',
        'seminar_status' => $seminar->status
    ]);
}

private function updatePengajuanBimbingan($request)
{
    $pengajuan = Pengajuan::find($request->id_pengajuan);
    $dosen = Auth::guard('dosen')->user();

    if (!$pengajuan) {
        return response()->json(['message' => 'Data pengajuan tidak ditemukan'], 404);
    }

    // Update pengajuan status
    $pengajuan->status = $request->status;
    $pengajuan->save();

    // If accepted, update or create pembimbing record
    if ($request->status === 'diterima') {
        $pembimbing = Pembimbing::firstOrNew(['id_mahasiswa' => $pengajuan->id_mahasiswa]);

        if ($pengajuan->dosen_ke == 1) {
            $pembimbing->id_dosen_1 = $dosen->id_dosen;
        } else if ($pengajuan->dosen_ke == 2) {
            $pembimbing->id_dosen_2 = $dosen->id_dosen;
        }

        $pembimbing->save();

        $message = "Pengajuan bimbingan Anda telah disetujui oleh {$dosen->nama}";
    } else {
        $message = "Pengajuan bimbingan Anda ditolak oleh {$dosen->nama}";
    }

    // Create notification
    Notifikasi::create([
        'id_user' => $pengajuan->id_mahasiswa,
        'role' => 'mahasiswa',
        'tipe_notifikasi' => 'Pengajuan Bimbingan',
        'pesan' => $message . ($request->status === 'ditolak' ? ". Alasan: {$request->alasan}" : ""),
        'tanggal_kirim' => now(),
        'status_baca' => 'belum'
    ]);

    return response()->json([
        'message' => 'Status pengajuan berhasil diperbarui',
        'status' => $pengajuan->status
    ]);
}
}
