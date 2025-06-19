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
            // Use the reusable function to get active guidance count (excluding graduated students)
            $result = ProfileDosenController::getDaftarMahasiswaBimbingan($dosen->id_dosen, true);
            $dosen->jumlah_pengajuan = $result['jumlahMahasiswa'];
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
            // Use the reusable function to get active guidance count (excluding graduated students)
            $result = ProfileDosenController::getDaftarMahasiswaBimbingan($satuan->id_dosen, true);
            $satuan->jumlah_pengajuan = $result['jumlahMahasiswa'];
        }

        return response()->json($dosen);
    }

    public function show($id)
    {
        $dosen = Dosen::where('id_dosen', $id)->first();

        // Use the reusable function to get supervised students (excluding graduated ones)
        $result = ProfileDosenController::getDaftarMahasiswaBimbingan($dosen->id_dosen, true);
        $ajuanBimbingan = $result['ajuanBimbingan'];
        $jumlahMahasiswa = $result['jumlahMahasiswa'];

        return view('detaildospem1', compact('dosen', 'ajuanBimbingan', 'jumlahMahasiswa'));
    }
}
