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

        return response()->json($dosens);
    }
    public function search(Request $request)
{
    $query = $request->get('q');

    $dosen = Dosen::where('nama', 'LIKE', "%$query%")
        ->orWhere('nip', 'LIKE', "%$query%")
        ->get();

    return response()->json($dosen);
}
}
