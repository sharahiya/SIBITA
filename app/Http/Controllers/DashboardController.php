<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Penguji;
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
        $penguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('urutan', 1)
            ->first() ?? null;
        $penguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('urutan', 2)
            ->first() ?? null;

        // dd($pengajuan->where('dosen_ke',1)->first()?);
        $seminars = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->get();

        $status = [];

        // Loop through seminars and add to status


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

        foreach ($seminars as $seminar) {
            $status[] = [
            'tanggal' => optional($seminar->tanggal_seminar)->format('d F Y'),
            'judul' => 'Seminar ' . ucfirst($seminar->jenis),
            'deskripsi' => 'Seminar ' . ucfirst($seminar->jenis) . ' telah dilaksanakan'
            ];
        }

    if(isset($penguji1)){
        $status[] = [
            'tanggal' => optional($penguji1->created_at)->format('d F y'),
            'judul' => 'Penetapan Penguji 1',
            'deskripsi' => 'Penguji 1 telah ditetapkan oleh koordinator TA'
        ];
    }

    if(isset($penguji2)){
        $status[] = [
            'tanggal' => optional($penguji2->created_at)->format('d F y'),
            'judul' => 'Penetapan Penguji 2',
            'deskripsi' => 'Penguji 2 telah ditetapkan oleh koordinator TA'
        ];
    }

    // Sort status array by tanggal (date)
    usort($status, function($a, $b) {
        $dateA = \DateTime::createFromFormat('d F Y', $a['tanggal'] ?? '') ?:
                 \DateTime::createFromFormat('d F y', $a['tanggal'] ?? '');
        $dateB = \DateTime::createFromFormat('d F Y', $b['tanggal'] ?? '') ?:
                 \DateTime::createFromFormat('d F y', $b['tanggal'] ?? '');

        // Handle cases where dates might be null
        if (!$dateA && !$dateB) return 0;
        if (!$dateA) return 1;
        if (!$dateB) return -1;

        return $dateA <=> $dateB;
    });


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
