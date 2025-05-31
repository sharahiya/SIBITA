<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
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
}
