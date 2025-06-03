<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatDosenController extends Controller
{
    public function index()
    {
        $dosenId = Auth::guard('dosen')->user()->id_dosen;

        $mahasiswaBimbingan = Pengajuan::where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->orderByDesc('created_at')
            ->get();

        // mendapatkan status seminar setiap mahasiswa dengan jenis sidang dan status diterima
        // dd($mahasiswaBimbingan);

        $riwayat = $mahasiswaBimbingan->map(function ($pengajuan) {
            $seminars = $pengajuan->mahasiswa->seminars()
            ->where('jenis', 'sidang')
            ->where('status', 'diterima')
            ->get();


            $seminarStatus = [];

            foreach ($seminars as $seminar) {
            $seminarStatus[] = [
                'jenis' => $seminar->jenis,
                'tanggal' => optional($seminar->tanggal_seminar)->format('d F Y'),
                'status' => $seminar->status,
                'lampiran' => $seminar->lampiran,
            ];
            }

            return [
                'mahasiswa' => $pengajuan->mahasiswa,
                'seminars' => $seminarStatus,
                'seminar' => $seminarStatus,
                'pengajuan' => $pengajuan,
            ];
        });
        // dd($seminarStatus);

        return view('riwayatdosen', compact('riwayat'));
    }
}
