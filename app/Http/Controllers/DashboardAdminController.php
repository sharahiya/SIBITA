<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        // Statistik dasar
        $jumlahMahasiswa = Mahasiswa::count();
        $jumlahDosen = Dosen::count();
        $mahasiswaAktifTA = Pengajuan::where('status', 'aktif')->count();

        // Inisialisasi tahun & semester (bisa disesuaikan logika real)
        $listTahun = ['2023/2024', '2024/2025', '2025/2026'];
        $listSemester = ['Genap', 'Ganjil'];

        // Simulasi data rekap, harusnya dari data nyata (misal: berdasarkan tanggal seminar atau status)
        $rekap = [];
        foreach ($listTahun as $tahun) {
            foreach ($listSemester as $semester) {
                $rekap[$tahun][$semester] = [
                    'sempro' => Seminar::where('status', 'sempro_selesai')->count(),
                    'semhas' => Seminar::where('status', 'semhas_selesai')->count(),
                    'sidang' => Seminar::where('status', 'sidang_selesai')->count(),
                    'aktif'  => Pengajuan::where('status', 'aktif')->count(),
                ];
            }
        }

        // Data Penjadwalan Terdekat (simulasi)
        $penjadwalan = Seminar::with(['pengajuan.mahasiswa'])
            ->orderBy('tanggal_seminar', 'asc')
            ->take(5)
            ->get()
            ->map(function ($s) {
                return [
                    'nama'    => $s->pengajuan->mahasiswa->nama ?? '-',
                    'npm'     => $s->pengajuan->mahasiswa->npm ?? '-',
                    'ujian'   => strtoupper(str_replace('_selesai', '', $s->status)),
                    'judul'   => $s->pengajuan->topik_ta ?? '-',
                    'peran'   => 'Peserta', // Bisa diperluas jika ada field peran
                    'tanggal' => Carbon::parse($s->tanggal_seminar)->format('d M Y'),
                    'waktu'   => Carbon::parse($s->tanggal_seminar)->format('H:i'),
                    'ruangan' => 'Ruang 1', // Dummy, ganti jika ada field ruangan
                ];
            });

        // Ambil default nilai tahun & semester untuk ditampilkan pertama kali
        $tahunDefault = '2024/2025';
        $semesterDefault = 'Genap';

        return view('dashboardadmin', compact(
            'jumlahMahasiswa',
            'jumlahDosen',
            'mahasiswaAktifTA',
            'rekap',
            'penjadwalan',
            'tahunDefault',
            'semesterDefault'
        ));
    }
}
