<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileDosenController extends Controller
{
    /**
     * Get list of students under supervision for a specific lecturer
     *
     * @param int $dosenId - ID of the lecturer
     * @param bool $excludeGraduated - Whether to exclude students who have completed their thesis defense
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getMahasiswaBimbingan($dosenId, $excludeGraduated = true)
    {
        // Get all approved guidance applications for this lecturer
        $ajuanBimbingan = Pengajuan::where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->with([
                'mahasiswa',
                'mahasiswa.seminars',
                'mahasiswa.seminars.pengajuanSeminar'
            ])
            ->get();

        if ($excludeGraduated) {
            // Filter: only students who haven't defended their thesis yet
            $ajuanBimbingan = $ajuanBimbingan->filter(function ($pengajuan) use ($dosenId) {
                $mahasiswa = $pengajuan->mahasiswa;

                // If no seminars at all, include the student
                if ($mahasiswa->seminars->isEmpty()) {
                    return true;
                }

                // Check if there's a thesis defense seminar that's been accepted
                $hasSidangDiterima = $mahasiswa->seminars->contains(function ($seminar) {
                    return $seminar->jenis === 'sidang' && $seminar->status === 'diterima';
                });

                // Check if there's a thesis defense seminar application already accepted by this lecturer
                $hasSidangApprovedByDosen = $mahasiswa->seminars->contains(function ($seminar) use ($dosenId) {
                    if ($seminar->jenis === 'sidang' && $seminar->pengajuanSeminar) {
                        return $seminar->pengajuanSeminar->contains(function ($pengajuanSeminar) use ($dosenId) {
                            return $pengajuanSeminar->id_dosen == $dosenId &&
                                $pengajuanSeminar->status == 'diterima';
                        });
                    }
                    return false;
                });

                // Include only if not defended yet and no thesis defense application approved by this lecturer
                return !$hasSidangDiterima && !$hasSidangApprovedByDosen;
            });
        }

        return $ajuanBimbingan;
    }

    /**
     * Set seminar status for each student based on their progress
     *
     * @param \Illuminate\Database\Eloquent\Collection $ajuanBimbingan
     * @param int $dosenId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function setSeminarStatus($ajuanBimbingan, $dosenId)
    {
        $ajuanBimbingan->each(function ($pengajuan) use ($dosenId) {
            $mahasiswa = $pengajuan->mahasiswa;
            $seminars = $mahasiswa->seminars;

            // Default status
            $pengajuan->mahasiswa->seminar_status = 'Bimbingan';

            if ($seminars->isNotEmpty()) {
                // Find seminar applications approved by this lecturer
                $approvedProposal = false;
                $approvedHasil = false;
                $approvedSidang = false;
                $completedProposal = false;
                $completedHasil = false;
                $completedSidang = false;

                foreach ($seminars as $seminar) {
                    // Check applications approved by lecturer
                    $pengajuanDiterima = $seminar->pengajuanSeminar->where('id_dosen', $dosenId)
                        ->where('status', 'diterima')->first();

                    if ($pengajuanDiterima) {
                        if ($seminar->jenis === 'proposal') {
                            $approvedProposal = true;
                        } elseif ($seminar->jenis === 'hasil') {
                            $approvedHasil = true;
                        } elseif ($seminar->jenis === 'sidang') {
                            $approvedSidang = true;
                        }
                    }

                    // Check completed seminars
                    if ($seminar->status === 'diterima') {
                        if ($seminar->jenis === 'proposal') {
                            $completedProposal = true;
                        } elseif ($seminar->jenis === 'hasil') {
                            $completedHasil = true;
                        } elseif ($seminar->jenis === 'sidang') {
                            $completedSidang = true;
                        }
                    }
                }

                // Determine status based on priority
                if ($completedSidang || $approvedSidang) {
                    $pengajuan->mahasiswa->seminar_status = 'Sidang';
                } elseif ($completedHasil) {
                    $pengajuan->mahasiswa->seminar_status = 'Semhas';
                } elseif ($approvedHasil) {
                    $pengajuan->mahasiswa->seminar_status = 'Semhas';
                } elseif ($completedProposal) {
                    $pengajuan->mahasiswa->seminar_status = 'Sempro';
                } elseif ($approvedProposal) {
                    $pengajuan->mahasiswa->seminar_status = 'Sempro';
                }
            }
        });

        return $ajuanBimbingan;
    }

    /**
     * Get supervised students with their seminar status (main function)
     *
     * @param int $dosenId
     * @param bool $excludeGraduated
     * @return array
     */
    public static function getDaftarMahasiswaBimbingan($dosenId, $excludeGraduated = false)
    {
        // Get all pengajuan that are accepted for this dosen
        $ajuanBimbingan = Pengajuan::where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->with(['mahasiswa'])
            ->get();

        if ($excludeGraduated) {
            // Filter out students who have completed sidang
            $ajuanBimbingan = $ajuanBimbingan->filter(function($pengajuan) {
                $mahasiswaId = $pengajuan->id_mahasiswa;

                // Check if student has completed sidang
                $completedSidang = PengajuanSeminar::where('id_mahasiswa', $mahasiswaId)
                    ->where('jenis', 'sidang')
                    ->where(function($query) {
                        $query->where('status', 'diterima')
                              ->orWhere('lulus', 1);
                    })
                    ->exists();

                return !$completedSidang;
            });
        }

        return [
            'ajuanBimbingan' => $ajuanBimbingan,
            'jumlahMahasiswa' => $ajuanBimbingan->count()
        ];
    }

    public static function getGuidanceBreakdown($dosenId)
    {
        // Get all accepted pengajuan for this dosen
        $pengajuanIds = Pengajuan::where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->pluck('id_mahasiswa')
            ->unique();

        $breakdown = [
            'bimbingan' => 0,
            'sempro' => 0,
            'semhas' => 0,
            'sidang' => 0
        ];

        foreach ($pengajuanIds as $mahasiswaId) {
            $mahasiswa = Mahasiswa::find($mahasiswaId);

            if ($mahasiswa) {
                // Check if student has completed sidang (graduated)
                $completedSidang = Seminar::where('id_mahasiswa', $mahasiswaId)
                    ->where('jenis', 'sidang')
                    ->where(function($query) {
                        $query->where('status', 'diterima')
                              ->orWhere('lulus', 1);
                    })
                    ->exists();

                // Skip graduated students
                if ($completedSidang) {
                    continue;
                }

                // Get seminar status using the accessor
                $status = $mahasiswa->seminar_status;

                switch ($status) {
                    case 'Bimbingan':
                        $breakdown['bimbingan']++;
                        break;
                    case 'Sempro':
                        $breakdown['sempro']++;
                        break;
                    case 'Semhas':
                        $breakdown['semhas']++;
                        break;
                    case 'Sidang':
                        $breakdown['sidang']++;
                        break;
                }
            }
        }

        return $breakdown;
    }

    public function index()
    {
        $user = Auth::guard('dosen')->user();
        $dosen = Dosen::where('id_dosen', $user->id_dosen)->first();

        // Use the reusable function
        $result = self::getDaftarMahasiswaBimbingan($dosen->id_dosen);
        $ajuanBimbingan = $result['ajuanBimbingan'];
        $jumlahMahasiswa = $result['jumlahMahasiswa'];

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

        // Create notification for student
        $idDosen = Auth::guard('dosen')->user()->id_dosen;
        Notifikasi::create([
            'id_user' => $pengajuan->id_mahasiswa,
            'role' => 'mahasiswa',
            'tipe_notifikasi' => 'Bimbingan Dihapus',
            'pesan' => 'Status Bimbingan Anda telah dihapus oleh Dosen ' . Auth::guard('dosen')->user()->nama . '.',
            'tanggal_kirim' => now(),
            'status_baca' => 'belum',
        ]);

        // Update bimbingan
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
