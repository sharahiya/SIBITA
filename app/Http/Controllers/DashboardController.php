<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Ambil pengajuan berdasarkan mahasiswa login
        $pengajuan = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->latest()->get();

        // Tentukan dospem berdasarkan atribut "dosen_ke"
        $pengajuan1 = $pengajuan->where('dosen_ke', 1)->first();
        $pengajuan2 = $pengajuan->where('dosen_ke', 2)->first();
        $dospem1 = $pengajuan1?->dosenPembimbing1 ?? null;
        $dospem2 = $pengajuan2?->dosenPembimbing2 ?? null;
        $penguji1 = $pengajuan[0]?->penguji1 ?? null;
        $penguji2 = $pengajuan[0]?->penguji2 ?? null;

        // dd($pengajuan->where('dosen_ke',1)->first()?);
        $seminars = [];

        $seminars = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->get();
        // dd($seminars['proposal']);


    $status = [];


    if (isset($pengajuan1) && $pengajuan1?->status == "diterima") {
        $latestPengajuanDospem1 = $pengajuan->where('dosen_ke', 1)->first();

        $status[] = [
            'tanggal' => optional($latestPengajuanDospem1?->created_at)->format('d F Y'),
            'judul' => 'Pengajuan Bimbingan Dosen 1',
            'deskripsi' => 'Dosen pembimbing 1 telah disetujui.'
        ];
    }

    if (isset($pengajuan2) && $pengajuan2?->status == "diterima") {
        $latestPengajuanDospem2 = $pengajuan->where('dosen_ke', 2)->first();

        $status[] = [
            'tanggal' => optional($latestPengajuanDospem2?->created_at)->format('d F Y'),
            'judul' => 'Pengajuan Bimbingan Dosen 2',
            'deskripsi' => 'Dosen pembimbing 2 telah disetujui.'
        ];
    }

    if (isset($seminars['proposal'])) {
        $status[] = [
            'tanggal' => optional($seminars['proposal']->first()->tanggal_seminar)->format('d F Y'),
            'judul' => 'Seminar Proposal',
            'deskripsi' => 'Proposal telah diseminarkan.'
        ];
    }

    if (isset($seminars['hasil'])) {
        $status[] = [
            'tanggal' => optional($seminars['hasil']->first()->tanggal_seminar)->format('d F Y'),
            'judul' => 'Seminar Hasil',
            'deskripsi' => 'Hasil penelitian telah diseminarkan.'
        ];
    }

    if (isset($seminars['sidang'])) {
        $status[] = [
            'tanggal' => optional($seminars['sidang']->first()->tanggal_seminar)->format('d F Y'),
            'judul' => 'Sidang',
            'deskripsi' => 'Sidang akhir telah dilaksanakan.'
        ];
    }


        return view('dashboard', [
            'mahasiswa' => $mahasiswa,
            'dospem1' => $dospem1,
            'dospem2' => $dospem2,
            'penguji1' => $penguji1,
            'penguji2' => $penguji2,
            'status' => $status,
        ]);
    }
}
