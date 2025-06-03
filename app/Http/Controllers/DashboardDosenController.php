<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $dosenId = $dosen->id_dosen;


    // Mahasiswa bimbingan dari pengajuan
    $bimbingan = Pengajuan::where('id_dosen', $dosenId)->where('status', 'diterima')->get();
    $bimbinganCount = $bimbingan->count();

    // Ambil ID mahasiswa bimbingan
    $mahasiswaIds = $bimbingan->pluck('id_mahasiswa');

    $mahasiswaBimbingan = Pengajuan::where(function($q) use ($dosenId) {
        $q->where('id_dosen', $dosenId);
    })->get();

    $pengajuanIds = $mahasiswaBimbingan->pluck('id_pengajuan');

    $seminars = Seminar::with(['mahasiswa'])
        ->whereIn('id_mahasiswa', $mahasiswaIds)
        ->where('status', 'selesai')
        ->get();

        $selesaiSempro = $seminars->where('jenis', 'proposal')->count();
        $selesaiSemhas = $seminars->where('jenis', 'hasil')->count();
        $selesaiSidang = $seminars->where('jenis', 'sidang')->count();

    // Dummy jadwal
    $jadwalSaya = collect([
        (object)[
            'mahasiswa' => (object)['nama' => 'Sharahiya', 'npm' => '2108107010082'],
            'jenis_ujian' => 'Seminar Proposal',
            'topik_ta' => 'Analisis AI dalam Pendidikan',
            'peran' => 'Dosen Pembimbing',
            'tanggal' => '2024-07-12',
            'jam' => '10.00 - Selesai',
            'ruangan' => 'Ruang 101',
        ],
    ]);

    return view('dashboarddosen', compact(
        'dosen',
        'bimbinganCount',
        'selesaiSempro',
        'selesaiSemhas',
        'selesaiSidang',
        'jadwalSaya'
    ));
    }
}
