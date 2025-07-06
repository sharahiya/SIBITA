<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pembimbing;
use App\Models\Pengajuan;
use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        // Statistik dasar
        $jumlahMahasiswa = Mahasiswa::count();
        $jumlahDosen = Dosen::count();
        $mahasiswaAktifTA = Pembimbing::all()->count();

        // Inisialisasi tahun & semester (bisa disesuaikan logika real)
        $listTahun = ['2023/2024', '2024/2025', '2025/2026'];
        $listSemester = ['Genap', 'Ganjil'];

        // Hitung rekap dengan logika yang diperbaiki
        $rekap = [];
        foreach ($listTahun as $tahun) {
            foreach ($listSemester as $semester) {
                // Ambil semua mahasiswa yang punya seminar
                $mahasiswaWithSeminar = Mahasiswa::whereHas('seminars', function($query) {
                    $query->where('status', 'diterima');
                })->with(['seminars' => function($query) {
                    $query->where('status', 'diterima')->orderBy('created_at', 'desc');
                }])->get();

                $sempro = 0;
                $semhas = 0;
                $sidang = 0;

                foreach ($mahasiswaWithSeminar as $mahasiswa) {
                    $latestSeminar = $mahasiswa->seminars->first();

                    if ($latestSeminar) {
                        switch ($latestSeminar->jenis) {
                            case 'proposal':
                                $sempro++;
                                break;
                            case 'hasil':
                                $semhas++;
                                break;
                            case 'sidang':
                                $sidang++;
                                break;
                        }
                    }
                }

                $rekap[$tahun][$semester] = [
                    'sempro' => $sempro,
                    'semhas' => $semhas,
                    'sidang' => $sidang,
                    'aktif'  => Pembimbing::all()->count(),
                ];
            }
        }

        // Data Penjadwalan Terdekat dengan logika yang diperbaiki
        $penjadwalan = Seminar::with(['mahasiswa'])
            ->where('tanggal_seminar', '>=', Carbon::now())
            ->orderBy('tanggal_seminar', 'asc')
            ->get()
            ->filter(function ($seminar) {
                $mahasiswa = $seminar->mahasiswa;

                // Ambil seminar terakhir yang diterima untuk mahasiswa ini
                $latestSeminar = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                    ->where('status', 'diterima')
                    ->orderBy('created_at', 'desc')
                    ->first();

                // Jika tidak ada seminar yang diterima sebelumnya, tampilkan
                if (!$latestSeminar) {
                    return true;
                }

                // Logika filter berdasarkan tahap terakhir
                switch ($latestSeminar->jenis) {
                    case 'sidang':
                        // Jika sudah sidang, jangan tampilkan seminar apapun lagi
                        return false;
                    case 'hasil':
                        // Jika sudah semhas, hanya tampilkan sidang
                        return $seminar->jenis === 'sidang';
                    case 'proposal':
                        // Jika sudah sempro, tampilkan semhas atau sidang
                        return in_array($seminar->jenis, ['hasil', 'sidang']);
                    default:
                        return true;
                }
            })
            ->take(5)
            ->map(function ($s) {
                $pengajuanBimbingan = Pengajuan::where('id_mahasiswa', $s->id_mahasiswa)
                    ->where('status', 'diterima')
                    ->first();

                return [
                    'nama'    => $s->mahasiswa->nama ?? '-',
                    'npm'     => $s->mahasiswa->npm ?? '-',
                    'ujian'   => $this->getUjianType($s->jenis),
                    'judul'   => $pengajuanBimbingan->topik_ta ?? '-',
                    'peran'   => 'Peserta',
                    'tanggal' => Carbon::parse($s->tanggal_seminar)->format('d M Y'),
                    'waktu'   => Carbon::parse($s->tanggal_seminar)->format('H:i'),
                    'ruangan' => $s->ruangan ?? 'Ruang 1',
                ];
            });

        // Ambil default nilai tahun & semester untuk ditampilkan pertama kali
        $tahunDefault = '2024/2025';
        $semesterDefault = 'Genap';

        $dummyDataPenjadwalan = [
            ['nama'    => 'Muhammad Ali',
            'npm'     => '2108107010039',
            'ujian'   => 'Seminar Proposal',
            'judul'   => 'RANCANG BANGUN SISTEM AUDIT INTERNAL BERBASIS WEB PADA UPT LABPRATORIUM TERPADU UNIVERSITAS SYIAH KUALA',
            'peran'   => 'Peserta',
            'tanggal' => Carbon::now()->format('d M Y'),
            'waktu'   => Carbon::now()->format('H:i'),
            'ruangan' => 'Seminar A 01.01',],
            ['nama'    => 'Ihsan Maulana',
            'npm'     => '2108107010049',
            'ujian'   => 'Seminar Hasil',
            'judul'   => 'KLASIFIKASI PASIEN KANKER LAYAK KEMOTRAPI BERDASARKAN DATA HASIL TES DARAH MENGGUNAKAN METODE SVM, K-NN, NAIVE BAYES, DAN DECISION TREE',
            'peran'   => 'Peserta',
            'tanggal' => Carbon::now()->addDays(1)->format('d M Y'),
            'waktu'   => Carbon::now()->addHours(1)->format('H:i'),
            'ruangan' => 'Seminar A 01.02',],
            ['nama'    => 'Reza Rahardia',
            'npm'     => '2108107010059',
            'ujian'   => 'Sidang',
            'judul'   => 'RANCANG BANGUN SISTEM INFORMASI PENJADWALAN IMUNISASI BADUTA BERBASIS WEB DAN WHATSAPP GATEWAY DI PUSKESMAS KECAMATAN SYIAH KUALA',
            'peran'   => 'Peserta',
            'tanggal' => Carbon::now()->addDays(2)->format('d M Y'),
            'waktu'   => Carbon::now()->addHours(2)->format('H:i'),
            'ruangan' => 'Seminar A 01.03',],
        ];

        usort($dummyDataPenjadwalan, function ($a, $b) {
            return strtotime($b['waktu']) - strtotime($a['waktu']);
        });

        return view('dashboardadmin', compact(
            'jumlahMahasiswa',
            'jumlahDosen',
            'mahasiswaAktifTA',
            'rekap',
            'penjadwalan',
            'tahunDefault',
            'semesterDefault',
            'dummyDataPenjadwalan',
        ));
    }

    private function getUjianType($jenis)
    {
        switch ($jenis) {
            case 'proposal':
                return 'Seminar Proposal';
            case 'hasil':
                return 'Seminar Hasil';
            case 'sidang':
                return 'Sidang';
            default:
                return ucfirst($jenis);
        }
    }

    public function changePassword(Request $request)
    {
        try {

            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ], [
                'current_password.required' => 'Password lama wajib diisi',
                'new_password.required' => 'Password baru wajib diisi',
                'new_password.min' => 'Password baru minimal 6 karakter',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok',
            ]);

            // Ambil admin yang sedang login
            $admin = Auth::guard('admin')->user();

            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin tidak ditemukan'
                ], 401);
            }

            // Verifikasi password lama
            if (!Hash::check($request->current_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak sesuai'
                ], 422);
            }

            // Cek apakah password baru sama dengan password lama
            if (Hash::check($request->new_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password baru tidak boleh sama dengan password lama'
                ], 422);
            }

            // Update password
            $admin->update([
                'password' => Hash::make($request->new_password)
            ]);

            // Log activity (optional)
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah'
            ]);

        } catch (\Exception $e) {


            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }
}
