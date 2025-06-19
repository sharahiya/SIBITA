<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\PengajuanSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatDosenController extends Controller
{
    public function index()
    {
        $dosenId = Auth::guard('dosen')->user()->id_dosen;

        // Ambil semua pengajuan seminar yang sudah diapprove oleh dosen ini untuk sidang
        $pengajuanSeminarSidang = PengajuanSeminar::where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->with([
                'seminar' => function($query) {
                    $query->where('jenis', 'sidang');
                },
                'seminar.mahasiswa',
                'mahasiswa'
            ])
            ->whereHas('seminar', function($query) {
                $query->where('jenis', 'sidang');
            })
            ->orderByDesc('created_at')
            ->get();

        $riwayat = $pengajuanSeminarSidang->map(function ($pengajuanSeminar) use ($dosenId) {
            $seminar = $pengajuanSeminar->seminar;
            $mahasiswa = $pengajuanSeminar->mahasiswa;

            // Ambil pengajuan bimbingan untuk mendapatkan data topik TA
            $pengajuanBimbingan = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                ->where('id_dosen', $dosenId)
                ->where('status', 'diterima')
                ->first();

            return [
                'mahasiswa' => $mahasiswa,
                'pengajuan_bimbingan' => $pengajuanBimbingan,
                'seminar' => [
                    'jenis' => $seminar->jenis,
                    'tanggal' => optional($seminar->tanggal_seminar)->format('d F Y'),
                    'status' => $seminar->status,
                    'lampiran' => $seminar->lampiran,
                    'status_pengajuan' => $pengajuanSeminar->status,
                    'tanggal_approved' => optional($pengajuanSeminar->updated_at)->format('d F Y')
                ],
                'pengajuan_seminar' => $pengajuanSeminar,
            ];
        });
        // dd($riwayat);
        return view('riwayatdosen', compact('riwayat'));
    }
}
