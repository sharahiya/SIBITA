<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DaftarDosenController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'datamining'); // Default tab adalah 'datamining'
    return view('daftardosen', compact('tab'));
    }

    public function getByBidang($bidang)
    {
        $dosens = Dosen::where('bidang', $bidang)->get();
        foreach($dosens as $dosen) {
            $jumlahPengajuan = $dosen->pengajuan()->where('status', 'diterima')->count();
            $dosen->jumlah_pengajuan = $jumlahPengajuan;

        }


        return response()->json($dosens);
    }
    public function search(Request $request)
    {
        $query = $request->get('q');

        $dosen = Dosen::where('nama', 'LIKE', "%$query%")
            ->orWhere('nip', 'LIKE', "%$query%")
            ->get();

            foreach($dosen as $satuan) {
                $jumlahPengajuan = $satuan->pengajuan()->where('status', '!=', 'selesai')->count();
                $satuan->jumlah_pengajuan = $jumlahPengajuan;

            }

        return response()->json($dosen);
    }

    public function show($id)
    {

        $dosen = Dosen::where('id_dosen', $id)->first();

        // Mahasiswa bimbingan (Dospem1 atau Dospem2)
        $ajuanBimbingan = Pengajuan::where('id_dosen', $dosen->id_dosen)
            ->where('status', 'diterima')
            ->with(['mahasiswa', 'mahasiswa.seminars']) // Eager load seminar data
            ->get();

        $jumlahMahasiswa = $ajuanBimbingan->count();

        // Check seminar status for each mahasiswa
        $ajuanBimbingan->each(function ($pengajuan) {
            $seminars = $pengajuan->mahasiswa->seminars;
            if ($seminars->isNotEmpty()) {
            $seminarStatuses = $seminars->map(function ($seminar) {
                switch ($seminar->jenis) {
                case 'sidang':
                    if ($seminar->status === 'diterima') {
                        return 'Sidang';
                    }
                    break; // Continue to the next case if not accepted
                case 'hasil':
                    if ($seminar->status === 'diterima') {
                        return 'Semhas';
                    }
                    break; // Continue to the next case if not accepted
                case 'proposal':
                    if ($seminar->status === 'diterima') {
                        return 'Sempro';
                    }
                    break; // Continue to the next case if not accepted
                default:
                    return 'Bimbingan';
                }
            })->unique(); // Ensure unique statuses

            if ($seminarStatuses->contains('Sidang')) {
                $pengajuan->mahasiswa->seminar_status = 'Sidang';
            } elseif ($seminarStatuses->contains('Semhas')) {
                $pengajuan->mahasiswa->seminar_status = 'Semhas';
            } elseif ($seminarStatuses->contains('Sempro')) {
                $pengajuan->mahasiswa->seminar_status = 'Sempro';
            } else {
                $pengajuan->mahasiswa->seminar_status = 'Bimbingan';
            }
        }else {
                        $pengajuan->mahasiswa->seminar_status = 'Bimbingan';

                }}
            );

        return view('detailDospem1', compact('dosen', 'ajuanBimbingan', 'jumlahMahasiswa'));
    }
}
