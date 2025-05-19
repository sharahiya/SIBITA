<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index()
    {
        $mahasiswaId = Auth::guard('mahasiswa')->user()->id_mahasiswa;

        // Cek apakah mahasiswa sudah mengajukan sebelumnya
        $existing = Pengajuan::where('id_mahasiswa', $mahasiswaId)
                    ->whereIn('status', ['pending', 'disetujui'])
                    ->first();

        if ($existing) {
            return redirect()->route('pengajuan.pending');
        }

        return view('pengajuan');
    }
    public function store(Request $request)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->user()->id_mahasiswa;

        $cekPengajuan = Pengajuan::where('id_mahasiswa', $mahasiswaId)
            ->whereIn('status', ['pending', 'disetujui'])
            ->first();

        if ($cekPengajuan) {
            return redirect()->route('pengajuan.pending');
        }

        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'dosenPembimbing' => 'required',
            'dosenPembimbing2' => 'nullable',
        ]);
        // $id = Dosen::where('nama', $request->dosenPembimbing)->first()?->id_dosen;
        // dd($id);

        Pengajuan::create([
            'id_mahasiswa' => $mahasiswaId,
            'topik_ta' => $request->judul,
            'deskripsi_ta' => $request->deskripsi,
            'id_dosen_1' => Dosen::where('nama', $request->dosenPembimbing)->first()?->id_dosen,
            'id_dosen_2' => Dosen::where('nama', $request->dosenPembimbing2)->first()?->id_dosen,
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('pengajuan.pending');
    }

    public function pending()
    {
    $userId = Auth::guard('mahasiswa')->user()->id_mahasiswa; // Pastikan user login adalah mahasiswa

    $pengajuan = Pengajuan::with(['mahasiswa', 'dosen1', 'dosen2'])
                    ->where('status', 'pending')
                    ->where('id_mahasiswa', $userId)
                    ->get();

    return view('pending', compact('pengajuan'));
    }
}
