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

        // Mahasiswa bimbingan dari pengajuan yang diterima
        $bimbingan = Pengajuan::where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->with(['mahasiswa'])
            ->get();

        // Hapus yang sudah sidang (completed thesis defense)
        $bimbingan = $bimbingan->filter(function ($pengajuan) use ($dosenId) {
            // Check if student has completed sidang for this specific dosen
            $completedSidang = PengajuanSeminar::where('id_mahasiswa', $pengajuan->id_mahasiswa)
                ->where('id_dosen', $dosenId)
                ->whereHas('seminar', function($query) {
                    $query->where('jenis', 'sidang');
                })
                ->where('status', 'diterima')
                ->exists();

            return !$completedSidang;
        });

        $bimbinganCount = $bimbingan->count();

        // Get unique mahasiswa IDs from current guidance
        $mahasiswaIds = $bimbingan->pluck('id_mahasiswa')->unique();

        // Initialize counters
        $selesaiSempro = 0;
        $selesaiSemhas = 0;
        $selesaiSidang = 0;

        // Get latest seminar status for each student supervised by this dosen
        foreach ($mahasiswaIds as $mahasiswaId) {
            $latestSeminarStatus = $this->getLatestSeminarStatusForStudent($mahasiswaId, $dosenId);
            
            switch ($latestSeminarStatus) {
                case 'proposal':
                    $selesaiSempro++;
                    break;
                case 'hasil':
                    $selesaiSemhas++;
                    break;
                case 'sidang':
                    $selesaiSidang++;
                    break;
            }
        }

        // Dummy jadwal (you can replace this with real data)
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

    /**
     * Get the latest seminar status for a specific student and dosen
     * Returns the highest level seminar that has been approved by this dosen
     *
     * @param int $mahasiswaId
     * @param int $dosenId
     * @return string|null
     */
    private function getLatestSeminarStatusForStudent($mahasiswaId, $dosenId)
    {
        // Get all approved seminars for this student by this specific dosen
        $approvedSeminars = PengajuanSeminar::where('id_mahasiswa', $mahasiswaId)
            ->where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->with('seminar')
            ->get();

        // Check for the highest level seminar approved
        $hasSidang = false;
        $hasHasil = false;
        $hasProposal = false;

        foreach ($approvedSeminars as $pengajuanSeminar) {
            if ($pengajuanSeminar->seminar) {
                switch ($pengajuanSeminar->seminar->jenis) {
                    case 'sidang':
                        $hasSidang = true;
                        break;
                    case 'hasil':
                        $hasHasil = true;
                        break;
                    case 'proposal':
                        $hasProposal = true;
                        break;
                }
            }
        }

        // Return the highest level achieved
        if ($hasSidang) {
            return 'sidang';
        } elseif ($hasHasil) {
            return 'hasil';
        } elseif ($hasProposal) {
            return 'proposal';
        }

        return null; // No seminars approved yet
    }

    /**
     * Alternative method: Get seminar statistics using more efficient query
     * This method groups the data in a single query for better performance
     */
    private function getSeminarStatisticsEfficient($dosenId)
    {
        // Get all students supervised by this dosen
        $mahasiswaIds = Pengajuan::where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->pluck('id_mahasiswa')
            ->unique();

        // Get the latest approved seminar for each student
        $latestSeminars = [];
        
        foreach ($mahasiswaIds as $mahasiswaId) {
            // Get approved seminars for this student and dosen, ordered by seminar hierarchy
            $approvedSeminars = PengajuanSeminar::where('id_mahasiswa', $mahasiswaId)
                ->where('id_dosen', $dosenId)
                ->where('status', 'diterima')
                ->whereHas('seminar', function($query) {
                    $query->whereIn('jenis', ['proposal', 'hasil', 'sidang']);
                })
                ->with('seminar')
                ->get();

            // Determine the highest level seminar
            $highestLevel = null;
            $priority = ['proposal' => 1, 'hasil' => 2, 'sidang' => 3];
            $maxPriority = 0;

            foreach ($approvedSeminars as $pengajuan) {
                if ($pengajuan->seminar && isset($priority[$pengajuan->seminar->jenis])) {
                    if ($priority[$pengajuan->seminar->jenis] > $maxPriority) {
                        $maxPriority = $priority[$pengajuan->seminar->jenis];
                        $highestLevel = $pengajuan->seminar->jenis;
                    }
                }
            }

            if ($highestLevel) {
                $latestSeminars[$mahasiswaId] = $highestLevel;
            }
        }

        // Count each type
        $counts = array_count_values($latestSeminars);
        
        return [
            'selesaiSempro' => $counts['proposal'] ?? 0,
            'selesaiSemhas' => $counts['hasil'] ?? 0,
            'selesaiSidang' => $counts['sidang'] ?? 0,
        ];
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
