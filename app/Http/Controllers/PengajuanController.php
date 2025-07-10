<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use App\Notifications\PengajuanBimbinganNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

            $this->sendNotification($newPengajuan1);

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

                $this->sendNotification($newPengajuan2);

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

    private function sendNotification($pengajuan)
    {
        try {
            $dosen = $pengajuan->dosen;
            $mahasiswa = Auth::guard('mahasiswa')->user();

            // 1. Simpan notifikasi ke database (sistem lama)
            Notifikasi::create([
                'id_user' => $dosen->id_dosen,
                'role' => 'dosen',
                'tipe_notifikasi' => 'Pengajuan Bimbingan',
                'pesan' => 'Pengajuan Dosen Pembimbing ' . $pengajuan->dosen_ke . ' baru dari mahasiswa: ' . $mahasiswa->nama . '.',
                'tanggal_kirim' => now(),
                'status_baca' => 'belum'
            ]);

            // 2. Kirim email ke Gmail dosen (jika ada email)
            if ($dosen->email) {
                $this->sendEmailToGmail($pengajuan, $dosen, $mahasiswa);
            }

            Log::info('Notifikasi berhasil dikirim', [
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

    // Method untuk kirim email sederhana ke Gmail
    private function sendEmailToGmail($pengajuan, $dosen, $mahasiswa)
    {
        try {
            Mail::send([], [], function ($message) use ($pengajuan, $dosen, $mahasiswa) {
                $message->to($dosen->email, $dosen->nama)
                    ->subject('Pengajuan Bimbingan Baru - SIBITA')
                    ->html($this->buildEmailContent($pengajuan, $dosen, $mahasiswa));
            });

            Log::info('Email berhasil dikirim ke Gmail', [
                'dosen_email' => $dosen->email,
                'pengajuan_id' => $pengajuan->id_pengajuan
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mengirim email: ' . $e->getMessage(), [
                'dosen_email' => $dosen->email,
                'pengajuan_id' => $pengajuan->id_pengajuan,
                'error' => $e->getMessage()
            ]);
        }
    }

    // Method untuk buat konten email HTML sederhana
    private function buildEmailContent($pengajuan, $dosen, $mahasiswa)
    {
        $tanggalPengajuan = \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d F Y, H:i');
        $batasWaktu = \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->addDays(3)->format('d F Y, H:i');

        return "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #007bff; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background-color: #f9f9f9; }
                .info-box { background-color: white; padding: 15px; margin: 10px 0; border-left: 4px solid #007bff; }
                .warning { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 15px 0; }
                .button { background-color: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 15px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>SIBITA</h1>
                    <p>Sistem Informasi Bimbingan Tugas Akhir</p>
                </div>

                <div class='content'>
                    <h2>Pengajuan Bimbingan Baru</h2>
                    <p>Yth. <strong>{$dosen->nama}</strong>,</p>
                    <p>Anda telah menerima pengajuan bimbingan tugas akhir baru yang memerlukan persetujuan Anda.</p>

                    <div class='warning'>
                        <strong>⚠️ Perhatian:</strong> Pengajuan akan dibatalkan otomatis jika tidak ada respons dalam 3 hari.
                    </div>

                    <div class='info-box'>
                        <h3>Detail Pengajuan:</h3>
                        <p><strong>Nama Mahasiswa:</strong> {$mahasiswa->nama}</p>
                        <p><strong>NPM:</strong> {$mahasiswa->npm}</p>
                        <p><strong>Email:</strong> {$mahasiswa->email}</p>
                        <p><strong>Posisi:</strong> Dosen Pembimbing {$pengajuan->dosen_ke}</p>
                        <p><strong>Bidang:</strong> {$pengajuan->bidang}</p>
                        <p><strong>Judul TA:</strong> {$pengajuan->topik_ta}</p>
                        <p><strong>Deskripsi:</strong> {$pengajuan->deskripsi_ta}</p>
                    </div>

                    <div class='info-box'>
                        <p><strong>📅 Tanggal Pengajuan:</strong> {$tanggalPengajuan} WIB</p>
                        <p><strong>⏰ Batas Waktu Respons:</strong> {$batasWaktu} WIB</p>
                    </div>

                    <div style='text-align: center;'>
                        <a href='" . url('/requestdosen') . "' class='button'>Lihat & Proses Pengajuan</a>
                    </div>

                    <p>Silakan login ke sistem SIBITA untuk memberikan persetujuan atau penolakan terhadap pengajuan ini.</p>
                    <p>Terima kasih atas perhatian Anda.</p>
                </div>

                <div style='text-align: center; margin-top: 20px; color: #666; font-size: 12px;'>
                    <p>Email ini dikirim secara otomatis oleh sistem SIBITA</p>
                    <p>© " . date('Y') . " SIBITA - Sistem Informasi Bimbingan Tugas Akhir</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
