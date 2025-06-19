<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Penguji;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Cek apakah mahasiswa masih menggunakan password default
        $mustChangePassword = $mahasiswa->isUsingDefaultPassword();

        // Ambil pengajuan berdasarkan mahasiswa login
        $pengajuan = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->latest()->get();

        // Tentukan dospem berdasarkan atribut "dosen_ke"
        $pengajuan1 = $pengajuan->where('dosen_ke', 1)->first();
        $pengajuan2 = $pengajuan->where('dosen_ke', 2)->first();
        $dospem1 = $pengajuan1?->dosenPembimbing1 ?? null;
        $dospem2 = $pengajuan2?->dosenPembimbing2 ?? null;

        // Ambil semua penguji (termasuk penguji 3 yang opsional)
        $penguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('urutan', 1)
            ->first() ?? null;
        $penguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('urutan', 2)
            ->first() ?? null;
        $penguji3 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('urutan', 3)
            ->first() ?? null;

        $seminars = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->get();

        $status = [];

        // Untuk pengajuan, gunakan updated_at (waktu persetujuan/penolakan)
        if (isset($pengajuan1) && $pengajuan1?->status == "diterima") {
            $latestPengajuanDospem1 = $pengajuan->where('dosen_ke', 1)->first();

            $status[] = [
                'timestamp' => $latestPengajuanDospem1?->updated_at,
                'tanggal' => $latestPengajuanDospem1?->updated_at ?
                    Carbon::parse($latestPengajuanDospem1->updated_at)->format('d F Y') : '-',
                'judul' => 'Pengajuan Bimbingan Dosen 1',
                'deskripsi' => 'Dosen pembimbing 1 telah disetujui.',
                'sort_order' => 1 // Pengajuan pembimbing 1 pertama
            ];
        }

        if (isset($pengajuan2) && $pengajuan2?->status == "diterima") {
            $latestPengajuanDospem2 = $pengajuan->where('dosen_ke', 2)->first();

            $status[] = [
                'timestamp' => $latestPengajuanDospem2?->updated_at,
                'tanggal' => $latestPengajuanDospem2?->updated_at ?
                    Carbon::parse($latestPengajuanDospem2->updated_at)->format('d F Y') : '-',
                'judul' => 'Pengajuan Bimbingan Dosen 2',
                'deskripsi' => 'Dosen pembimbing 2 telah disetujui.',
                'sort_order' => 2 // Pengajuan pembimbing 2 kedua
            ];
        }

        // Untuk penetapan penguji setelah pengajuan pembimbing
        if(isset($penguji1)){
            $status[] = [
                'timestamp' => $penguji1->created_at,
                'tanggal' => $penguji1->created_at ?
                    Carbon::parse($penguji1->created_at)->format('d F Y') : '-',
                'judul' => 'Penetapan Penguji 1',
                'deskripsi' => 'Penguji 1 telah ditetapkan oleh koordinator TA',
                'sort_order' => 3 // Penguji 1 ketiga
            ];
        }

        if(isset($penguji2)){
            $status[] = [
                'timestamp' => $penguji2->created_at,
                'tanggal' => $penguji2->created_at ?
                    Carbon::parse($penguji2->created_at)->format('d F Y') : '-',
                'judul' => 'Penetapan Penguji 2',
                'deskripsi' => 'Penguji 2 telah ditetapkan oleh koordinator TA',
                'sort_order' => 4 // Penguji 2 keempat
            ];
        }

        if(isset($penguji3)){
            $status[] = [
                'timestamp' => $penguji3->created_at,
                'tanggal' => $penguji3->created_at ?
                    Carbon::parse($penguji3->created_at)->format('d F Y') : '-',
                'judul' => 'Penetapan Penguji 3',
                'deskripsi' => 'Penguji 3 (opsional) telah ditetapkan oleh koordinator TA',
                'sort_order' => 5 // Penguji 3 kelima
            ];
        }

        // Seminar setelah penetapan penguji dengan urutan logis
        foreach ($seminars as $seminar) {
            // Untuk seminar, prioritas: tanggal_seminar, kemudian created_at
            $eventTimestamp = null;
            $displayDate = '-';

            if ($seminar->tanggal_seminar) {
                $eventTimestamp = Carbon::parse($seminar->tanggal_seminar);
                $displayDate = $eventTimestamp->format('d F Y');
            } elseif ($seminar->created_at) {
                $eventTimestamp = $seminar->created_at;
                $displayDate = Carbon::parse($seminar->created_at)->format('d F Y');
            }

            // Urutan seminar yang logis
            $sortOrder = match($seminar->jenis) {
                'proposal' => 6, // Seminar proposal keenam
                'hasil' => 7,    // Seminar hasil ketujuh
                'sidang' => 8,   // Sidang kedelapan (terakhir)
                default => 9     // Jenis lain di akhir
            };

            $status[] = [
                'timestamp' => $eventTimestamp,
                'tanggal' => $displayDate,
                'judul' => 'Seminar ' . ucfirst($seminar->jenis),
                'deskripsi' => 'Seminar ' . ucfirst($seminar->jenis) . ' telah dilaksanakan',
                'sort_order' => $sortOrder
            ];
        }

        // Sort status array by timestamp (lebih akurat dan efisien)
        usort($status, function($a, $b) {
            // berdasarkan sort_order
            return $b['sort_order'] <=> $a['sort_order'];
        });

        return view('dashboard', [
            'mahasiswa' => $mahasiswa,
            'dospem1' => $dospem1,
            'dospem2' => $dospem2,
            'penguji1' => $penguji1,
            'penguji2' => $penguji2,
            'penguji3' => $penguji3,
            'status' => $status,
            'mustChangePassword' => $mustChangePassword
        ]);
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

        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Verify current password
        if (!Hash::check($request->current_password, $mahasiswa->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak benar'
            ], 422);
        }

        // Update password
        $mahasiswa->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}
