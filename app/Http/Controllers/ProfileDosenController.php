<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileDosenController extends Controller
{
    public function index()
    {
        $user = Auth::guard('dosen')->user();
        $dosen = Dosen::where('id_dosen', $user->id_dosen)->first();

        // Mahasiswa bimbingan (Dospem1 atau Dospem2)
        $ajuanBimbingan = Pengajuan::where('id_dosen_1', $dosen->id_dosen)
            ->orWhere('id_dosen_2', $dosen->id_dosen)
            ->with(['mahasiswa']) // Eager load
            ->get();

        $jumlahMahasiswa = $ajuanBimbingan->count();

        return view('profileDosen', compact('dosen', 'ajuanBimbingan', 'jumlahMahasiswa'));
    }


    public function updateKuota(Request $request)
    {
        $user = Auth::guard('dosen')->user();
        $request->validate(['kuota' => 'required|integer|min:1']);
        $dosen = Dosen::where('id_dosen', $user->id_dosen)->first();
        $dosen->kuota_bimbingan = $request->kuota;
        $dosen->save();

        return response()->json(['message' => 'Kuota berhasil diperbarui']);
    }

    public function updateWhatsapp(Request $request)
    {
        $user = Auth::guard('dosen')->user();
        $request->validate(['link' => 'required|string']);
        $dosen = Dosen::where('id_dosen', $user->id_dosen)->first();
        $dosen->link_wa_group = $request->link;
        $dosen->save();

        return response()->json(['message' => 'Link WhatsApp berhasil diperbarui']);
    }


}
