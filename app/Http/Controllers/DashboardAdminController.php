<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pembimbing;
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
        $mahasiswaAktifTA = Pembimbing::all()->count();

        // Inisialisasi tahun & semester (bisa disesuaikan logika real)
        $listTahun = ['2023/2024', '2024/2025', '2025/2026'];
        $listSemester = ['Genap', 'Ganjil'];

        // Simulasi data rekap, harusnya dari data nyata (misal: berdasarkan tanggal seminar atau status)
        $rekap = [];
        foreach ($listTahun as $tahun) {
            foreach ($listSemester as $semester) {
                $rekap[$tahun][$semester] = [
                    'sempro' => Seminar::where('jenis', 'proposal')->where('status', 'diterima')->count(),
                    'semhas' => Seminar::where('jenis', 'hasil')->where('status', 'diterima')->count(),
                    'sidang' => Seminar::where('jenis', 'sidang')->where('status', 'diterima')->count(),
                    'aktif'  => Pembimbing::all()->count(),
                ];
            }
        }

        // Data Penjadwalan Terdekat (simulasi)
        $penjadwalan = Seminar::with(['mahasiswa'])
    ->orderBy('tanggal_seminar', 'asc')
    ->take(5)
    ->get()
    ->map(function ($s) {
        return [
            'nama'    => $s->mahasiswa->nama ?? '-',
            'npm'     => $s->mahasiswa->npm ?? '-',
            'ujian'   => strtoupper(str_replace('_selesai', '', $s->status)),
            'judul'   => $s->judul ?? '-', // Langsung dari Seminar jika ada
            'peran'   => 'Peserta',
            'tanggal' => Carbon::parse($s->tanggal_seminar)->format('d M Y'),
            'waktu'   => Carbon::parse($s->tanggal_seminar)->format('H:i'),
            'ruangan' => $s->ruangan ?? 'Ruang 1',
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
