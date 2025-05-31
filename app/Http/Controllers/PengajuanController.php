<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index()
    {
        $mahasiswaId = Auth::guard('mahasiswa')->user()->id_mahasiswa;

        // Ambil pengajuan pertama (dosen_ke = 1)
        $pengajuan1 = Pengajuan::where('id_mahasiswa', $mahasiswaId)
                        ->where('dosen_ke', 1)
                        ->whereNotIn('status', ['ditolak'])
                        ->first();

        // Ambil pengajuan kedua (dosen_ke = 2)
        $pengajuan2 = Pengajuan::where('id_mahasiswa', $mahasiswaId)
                        ->where('dosen_ke', 2)
                        ->whereNotIn('status', ['ditolak'])
                        ->first();

        // Ambil dosen yang sudah diajukan dan statusnya bukan ditolak
        $dosenAktif = Pengajuan::where('id_mahasiswa', $mahasiswaId)
                        ->whereNotIn('status', ['ditolak'])
                        ->pluck('id_dosen')
                        ->toArray();



        return view('pengajuan', compact('pengajuan1', 'pengajuan2', 'dosenAktif'));
    }

    public function create()
    {
        $mahasiswaId = Auth::guard('mahasiswa')->user()->id_mahasiswa;

        // Ambil semua pengajuan aktif (pending / diterima)
        $pengajuanAktif = Pengajuan::where('id_mahasiswa', $mahasiswaId)
            ->whereIn('status', ['pending', 'diterima'])
            ->pluck('id_dosen')
            ->toArray();

        // Ambil semua pengajuan ditolak (boleh diajukan ulang)
        $pengajuanDitolak = Pengajuan::where('id_mahasiswa', $mahasiswaId)
            ->where('status', 'ditolak')
            ->pluck('id_dosen')
            ->toArray();

        return view('pengajuan.create', compact('pengajuanAktif', 'pengajuanDitolak'));
    }

    public function store(Request $request)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->user()->id_mahasiswa;

        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'dosenPembimbing' => 'nullable|string',
            'dosenPembimbing2' => 'nullable|string',
            'bidang' => 'required|string',
        ]);

        // Handle Dosen Pembimbing 1

        // dd($request->dosenPembimbing);
        $dosen1 = Dosen::where('nama', $request->dosenPembimbing)->first();
        if (!$dosen1) {
            return back()->withErrors(['dosenPembimbing' => 'Dosen pembimbing 1 tidak ditemukan.'])->withInput();
        }

        $pengajuan1 = Pengajuan::where('id_mahasiswa', $mahasiswaId)
                        ->where('dosen_ke', 1)
                        ->first();

        if ($pengajuan1) {
            if ($pengajuan1->status === 'ditolak') {
                // Update pengajuan 1 with new dosen or changes
                $pengajuan1->update([
                    'id_dosen' => $dosen1->id_dosen,
                    'topik_ta' => $request->judul,
                    'deskripsi_ta' => $request->deskripsi,
                    'bidang' => $request->bidang,
                    'status' => 'pending',
                    'tanggal_pengajuan' => now(),
                ]);
                // Simpan notifikasi untuk pengajuan baru
                Notifikasi::create([
                    'id_user' => $dosen1->id_dosen,
                    'role' => 'dosen',
                    'tipe_notifikasi' => 'Pengajuan Bimbingan',
                    'pesan' => 'Pengajuan Dosen Pembimbing 1 baru dari mahasiswa: ' . Auth::guard('mahasiswa')->user()->nama . '.',
                    'tanggal_kirim' => now(),
                    'status_baca' => 'belum'
                ]);
            } elseif ($pengajuan1->id_dosen === $dosen1->id_dosen) {
                // Update only judul or deskripsi if they are changed
                $pengajuan1->update([
                    'topik_ta' => $request->judul,
                    'deskripsi_ta' => $request->deskripsi,
                ]);
            } else {
                return back()->withErrors(['dosenPembimbing' => 'Dosen pembimbing 1 sudah diajukan sebelumnya dan tidak dapat diubah.'])->withInput();
            }
        } else {
            // Create new pengajuan for dosen pembimbing 1
            Pengajuan::create([
                'id_mahasiswa' => $mahasiswaId,
                'id_dosen' => $dosen1->id_dosen,
                'dosen_ke' => 1,
                'topik_ta' => $request->judul,
                'deskripsi_ta' => $request->deskripsi,
                'bidang' => $request->bidang,
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
            ]);

            // Simpan notifikasi untuk pengajuan baru
            Notifikasi::create([
                'id_user' => $dosen1->id_dosen,
                'role' => 'dosen',
                'tipe_notifikasi' => 'Pengajuan Bimbingan',
                'pesan' => 'Pengajuan Dosen Pembimbing 1 baru dari mahasiswa: ' . Auth::guard('mahasiswa')->user()->nama . '.',
                'tanggal_kirim' => now(),
                'status_baca' => 'belum'
            ]);
        }

        // Handle Dosen Pembimbing 2
        if ($request->filled('dosenPembimbing2')) {
            $dosen2 = Dosen::where('nama', $request->dosenPembimbing2)->first();
            if (!$dosen2) {
                return back()->withErrors(['dosenPembimbing2' => 'Dosen pembimbing 2 tidak ditemukan.'])->withInput();
            }

            $pengajuan2 = Pengajuan::where('id_mahasiswa', $mahasiswaId)
                            ->where('dosen_ke', 2)
                            ->first();

            if ($pengajuan2) {
                if ($pengajuan2->status === 'ditolak') {
                    // Update pengajuan 2 with new dosen or changes
                    $pengajuan2->update([
                        'id_dosen' => $dosen2->id_dosen,
                        'topik_ta' => $request->judul,
                        'deskripsi_ta' => $request->deskripsi,
                        'bidang' => $request->bidang,
                        'status' => 'pending',
                        'tanggal_pengajuan' => now(),
                    ]);

                    // Simpan notifikasi untuk pengajuan baru
                    Notifikasi::create([
                        'id_user' => $dosen2->id_dosen,
                        'role' => 'dosen',
                        'tipe_notifikasi' => 'Pengajuan Bimbingan',
                        'pesan' => 'Pengajuan Dosen Pembimbing 2 baru dari mahasiswa: ' . Auth::guard('mahasiswa')->user()->nama . '.',
                        'tanggal_kirim' => now(),
                        'status_baca' => 'belum'
                    ]);
                } elseif ($pengajuan2->id_dosen === $dosen2->id_dosen) {
                    // Update only judul or deskripsi if they are changed
                    $pengajuan2->update([
                        'topik_ta' => $request->judul,
                        'deskripsi_ta' => $request->deskripsi,
                    ]);
                } else {
                    return back()->withErrors(['dosenPembimbing2' => 'Dosen pembimbing 2 sudah diajukan sebelumnya dan tidak dapat diubah.'])->withInput();
                }
            } else {
                // Create new pengajuan for dosen pembimbing 2
                Pengajuan::create([
                    'id_mahasiswa' => $mahasiswaId,
                    'id_dosen' => $dosen2->id_dosen,
                    'dosen_ke' => 2,
                    'topik_ta' => $request->judul,
                    'deskripsi_ta' => $request->deskripsi,
                    'bidang' => $request->bidang,
                    'status' => 'pending',
                    'tanggal_pengajuan' => now(),
                ]);

                Notifikasi::create([
                    'id_user' => $dosen2->id_dosen,
                    'role' => 'dosen',
                    'tipe_notifikasi' => 'Pengajuan Bimbingan',
                    'pesan' => 'Pengajuan Dosen Pembimbing 2 baru dari mahasiswa: ' . Auth::guard('mahasiswa')->user()->nama . '.',
                    'tanggal_kirim' => now(),
                    'status_baca' => 'belum'
                ]);
            }
        }

        return redirect()->route('pengajuan.pending')->with('success', 'Pengajuan berhasil diajukan.');
    }

    public function pending()
    {
        $userId = Auth::guard('mahasiswa')->user()->id_mahasiswa;

        $pengajuan = Pengajuan::with(['mahasiswa', 'dosen'])
                        ->where('id_mahasiswa', $userId)
                        ->whereIn('status', ['pending', 'ditolak']) // tampilkan juga yang ditolak
                        ->get()
                        ->groupBy('topik_ta'); // Kelompokkan berdasarkan topik TA

        return view('pending', compact('pengajuan'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id_pengajuan' => 'required|exists:pengajuans,id_pengajuan',
            'status'       => 'required|in:diterima,ditolak',
            'alasan'       => 'nullable|string|max:255',
        ]);

        $pengajuan = Pengajuan::findOrFail($request->id_pengajuan);

        if ($pengajuan->status !== 'menunggu') {
            return response()->json(['message' => 'Pengajuan sudah diproses.'], 400);
        }

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
                'status_baca' => 'belum'
            ]);
        }

        return response()->json(['message' => 'Status pengajuan berhasil diperbarui.']);
    }

}
