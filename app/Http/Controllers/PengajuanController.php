<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    // Add this method to get lecturer data with proper guidance count
    public function getDosenData()
    {
        $dosens = Dosen::all();

        foreach($dosens as $dosen) {
            // Use the reusable function to get active guidance count (excluding graduated students)
            $result = ProfileDosenController::getDaftarMahasiswaBimbingan($dosen->id_dosen, true);
            $dosen->jumlah_bimbingan_aktif = $result['jumlahMahasiswa'];
        }

        return response()->json($dosens);
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
        $dosen1 = Dosen::where('nama', $request->dosenPembimbing)->first();
        if (!$dosen1) {
            return back()->withErrors(['dosenPembimbing' => 'Dosen pembimbing 1 tidak ditemukan.'])->withInput();
        }

        $pengajuan1 = Pengajuan::where('id_mahasiswa', $mahasiswaId)
                        ->where('dosen_ke', 1)
                        ->first();

        if ($pengajuan1) {
            if ($pengajuan1->status === 'ditolak' || $pengajuan1->status === 'cancelled') {
                // Update pengajuan 1 with new dosen or changes
                $pengajuan1->update([
                    'id_dosen' => $dosen1->id_dosen,
                    'topik_ta' => $request->judul,
                    'deskripsi_ta' => $request->deskripsi,
                    'bidang' => $request->bidang,
                    'status' => 'pending',
                    'tanggal_pengajuan' => now(),
                ]);

                // Kirim notifikasi + email
                $this->sendNotificationAndEmail($pengajuan1);

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
            $newPengajuan1 = Pengajuan::create([
                'id_mahasiswa' => $mahasiswaId,
                'id_dosen' => $dosen1->id_dosen,
                'dosen_ke' => 1,
                'topik_ta' => $request->judul,
                'deskripsi_ta' => $request->deskripsi,
                'bidang' => $request->bidang,
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
            ]);

            // Kirim notifikasi + email
            $this->sendNotificationAndEmail($newPengajuan1);
        }

        // Handle Dosen Pembimbing 2 (sama seperti di atas)
        if ($request->filled('dosenPembimbing2')) {
            $dosen2 = Dosen::where('nama', $request->dosenPembimbing2)->first();
            if (!$dosen2) {
                return back()->withErrors(['dosenPembimbing2' => 'Dosen pembimbing 2 tidak ditemukan.'])->withInput();
            }

            $pengajuan2 = Pengajuan::where('id_mahasiswa', $mahasiswaId)
                            ->where('dosen_ke', 2)
                            ->first();

            if ($pengajuan2) {
                if ($pengajuan2->status === 'ditolak' || $pengajuan2->status === 'cancelled') {
                    $pengajuan2->update([
                        'id_dosen' => $dosen2->id_dosen,
                        'topik_ta' => $request->judul,
                        'deskripsi_ta' => $request->deskripsi,
                        'bidang' => $request->bidang,
                        'status' => 'pending',
                        'tanggal_pengajuan' => now(),
                    ]);

                    $this->sendNotificationAndEmail($pengajuan2);

                } elseif ($pengajuan2->id_dosen === $dosen2->id_dosen) {
                    $pengajuan2->update([
                        'topik_ta' => $request->judul,
                        'deskripsi_ta' => $request->deskripsi,
                    ]);
                } else {
                    return back()->withErrors(['dosenPembimbing2' => 'Dosen pembimbing 2 sudah diajukan sebelumnya dan tidak dapat diubah.'])->withInput();
                }
            } else {
                $newPengajuan2 = Pengajuan::create([
                    'id_mahasiswa' => $mahasiswaId,
                    'id_dosen' => $dosen2->id_dosen,
                    'dosen_ke' => 2,
                    'topik_ta' => $request->judul,
                    'deskripsi_ta' => $request->deskripsi,
                    'bidang' => $request->bidang,
                    'status' => 'pending',
                    'tanggal_pengajuan' => now(),
                ]);

                $this->sendNotificationAndEmail($newPengajuan2);
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

    // Ganti method sendNotification dengan yang lebih sederhana
    private function sendNotificationAndEmail($pengajuan)
    {
        try {
            $dosen = $pengajuan->dosen;
            $mahasiswa = Auth::guard('mahasiswa')->user();

            // 1. Simpan notifikasi ke database
            $notifikasi = Notifikasi::create([
                'id_user' => $dosen->id_dosen,
                'role' => 'dosen',
                'tipe_notifikasi' => 'Pengajuan Bimbingan',
                'pesan' => 'Pengajuan Dosen Pembimbing ' . $pengajuan->dosen_ke . ' baru dari mahasiswa: ' . $mahasiswa->nama . '. Topik: ' . $pengajuan->topik_ta,
                'tanggal_kirim' => now(),
                'status_baca' => 'belum'
            ]);

            // 2. Email akan dikirim otomatis oleh NotifikasiObserver

            Log::info('Notifikasi dan email berhasil dikirim', [
                'pengajuan_id' => $pengajuan->id_pengajuan,
                'dosen_id' => $dosen->id_dosen,
                'dosen_email' => $dosen->email ?? 'No email',
                'mahasiswa_nama' => $mahasiswa->nama
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi: ' . $e->getMessage(), [
                'pengajuan_id' => $pengajuan->id_pengajuan ?? 'unknown',
                'error' => $e->getMessage()
            ]);
        }
    }
}
