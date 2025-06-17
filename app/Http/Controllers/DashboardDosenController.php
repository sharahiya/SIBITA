<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\PengajuanSeminar;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $dosenId = $dosen->id_dosen;

        // Cek apakah dosen masih menggunakan password default
        $mustChangePassword = $dosen->isUsingDefaultPassword();

        // Mahasiswa bimbingan dari pengajuan
        $bimbingan = Pengajuan::where('id_dosen', $dosenId)->where('status', 'diterima')->get();
        // dd($bimbingan);
        // hapus yang sudah sidang
        $bimbingan = $bimbingan->filter(function ($pengajuan) {
            return !$pengajuan->mahasiswa->seminars->contains(function ($seminar) {
                return $seminar->jenis === 'sidang' && $seminar->status === 'diterima';
            });
        });
        $bimbinganCount = $bimbingan->count();

        // Ambil ID mahasiswa bimbingan
        $mahasiswaIds = $bimbingan->pluck('id_mahasiswa');

        $mahasiswaBimbingan = Pengajuan::where(function($q) use ($dosenId) {
            $q->where('id_dosen', $dosenId);
        })->get();

        $pengajuanIds = $mahasiswaBimbingan->pluck('id_pengajuan');

        $seminars = PengajuanSeminar::with(['mahasiswa', 'seminar'])
            ->whereIn('id_pengajuan', $pengajuanIds)
            ->whereHas('seminar', function($query) {
            $query->whereIn('jenis', ['proposal', 'hasil', 'sidang']);
            })
            ->where('status', 'selesai')
            ->get();

        $selesaiSempro = $seminars->filter(function($item) {
            return $item->seminar->jenis === 'proposal';
        })->count();
        
        $selesaiSemhas = $seminars->filter(function($item) {
            return $item->seminar->jenis === 'hasil';
        })->count();
        
        $selesaiSidang = $seminars->filter(function($item) {
            return $item->seminar->jenis === 'sidang';
        })->count();

        // Dummy jadwal
        $jadwalSaya = collect([
            (object)[
                'mahasiswa' => (object)['nama' => 'Sharahiya', 'npm' => '2108107010082'],
                'jenis_ujian' => 'Seminar Proposal',
                'topik_ta' => 'Analisis AI dalam Pendidikan',
                'peran' => 'Dosen Pembimbing',
                'tanggal' => '2024-07-12',
                'jam' => '10.00 - Selesai',
                'ruangan' => 'Ruang 101',
            ],
        ]);

        return view('dashboarddosen', compact(
            'dosen',
            'bimbinganCount',
            'selesaiSempro',
            'selesaiSemhas',
            'selesaiSidang',
            'jadwalSaya',
            'mustChangePassword'
        ));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $dosen = Auth::guard('dosen')->user();

        // Verify current password
        if (!Hash::check($request->current_password, $dosen->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak benar'
            ], 422);
        }

        // Update password
        $dosen->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}
