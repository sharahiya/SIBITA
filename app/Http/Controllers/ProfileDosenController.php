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
        $ajuanBimbingan = Pengajuan::where('id_dosen', $dosen->id_dosen)
            ->where('status', 'diterima')
            ->with(['mahasiswa', 'mahasiswa.seminars']) // Eager load seminar data
            ->get();

        // Filter out mahasiswa with seminar type 'sidang' and status 'diterima'
        $ajuanBimbingan = $ajuanBimbingan->filter(function ($pengajuan) {
            $seminars = $pengajuan->mahasiswa->seminars;
            return !$seminars->contains(function ($seminar) {
                return $seminar->jenis === 'sidang' && $seminar->status === 'diterima';
            });
        });

        $jumlahMahasiswa = $ajuanBimbingan->count();

        // Check seminar status for each mahasiswa
        $ajuanBimbingan->each(function ($pengajuan) {
            $seminars = $pengajuan->mahasiswa->seminars;
            if ($seminars->isNotEmpty()) {
                $seminarStatuses = $seminars->map(function ($seminar) {
                    switch ($seminar->jenis) {
                        case 'hasil':
                            if ($seminar->status === 'diterima') {
                                return 'Semhas';
                            }
                            break;
                        case 'proposal':
                            if ($seminar->status === 'diterima') {
                                return 'Sempro';
                            }
                            break;
                        default:
                            return 'Bimbingan';
                    }
                })->unique(); // Ensure unique statuses

                if ($seminarStatuses->contains('Semhas')) {
                    $pengajuan->mahasiswa->seminar_status = 'Semhas';
                } elseif ($seminarStatuses->contains('Sempro')) {
                    $pengajuan->mahasiswa->seminar_status = 'Sempro';
                } else {
                    $pengajuan->mahasiswa->seminar_status = 'Bimbingan';
                }
            } else {
                $pengajuan->mahasiswa->seminar_status = 'Bimbingan';
            }
        });

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

    public function destroy($id)
{
    $pengajuan = Pengajuan::find($id);

    if (!$pengajuan) {
        return response()->json(['message' => 'Pengajuan tidak ditemukan'], 404);
    }

    $pengajuan->delete();

    // Buat Notifikasi untuk mahasiswa
    $idDosen = Auth::guard('dosen')->user()->id_dosen;
    Notifikasi::create([
        'id_user' => $pengajuan->id_mahasiswa,
        'role' => 'mahasiswa',
        'tipe_notifikasi' => 'Bimbingan Dihapus',
        'pesan' => 'Status Bimbingan Anda telah dihapus oleh Dosen ' . Auth::guard('dosen')->user()->nama . '.',
        'tanggal_kirim' => now(),
        'status_baca' => 'belum',
    ]);

    // update bimbingan
    $mahasiswa = Mahasiswa::find($pengajuan->id_mahasiswa);

    $bimbingan = $mahasiswa->bimbingan;
    if ($bimbingan) {
        if ($bimbingan->id_dosen_1 == $idDosen) {
            $bimbingan->id_dosen_1 = null;
        } elseif ($bimbingan->id_dosen_2 == $idDosen) {
            $bimbingan->id_dosen_2 = null;
        }
        $bimbingan->save();
    }
    return response()->json(['message' => 'Mahasiswa berhasil dihapus']);
}

}
