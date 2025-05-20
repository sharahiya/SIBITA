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
    $bimbinganCount = Pengajuan::where('id_dosen_1', $dosen->id_dosen)
                        ->orWhere('id_dosen_2', $dosen->id_dosen)
                        ->count();

    $mahasiswaBimbingan = Pengajuan::where(function($q) use ($dosenId) {
        $q->where('id_dosen_1', $dosenId)
            ->orWhere('id_dosen_2', $dosenId);
    })->get();

    $pengajuanIds = $mahasiswaBimbingan->pluck('id_pengajuan');

    $selesaiSempro = Seminar::whereIn('id_pengajuan', $pengajuanIds)
        ->where('jenis', 'proposal')
        ->where('status', 'selesai')
        ->count();

    $selesaiSemhas = Seminar::whereIn('id_pengajuan', $pengajuanIds)
        ->where('jenis', 'hasil')
        ->where('status', 'selesai')
        ->count();

    $selesaiSidang = Seminar::whereIn('id_pengajuan', $pengajuanIds)
        ->where('jenis', 'sidang')
        ->where('status', 'selesai')
        ->count();
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
