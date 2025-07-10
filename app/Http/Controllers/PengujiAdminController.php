<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\Penguji;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengujiAdminController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();

        // Ambil ID dosen pembimbing
        $dosenPembimbing1Id = $mahasiswa->dosenPembimbing1->id_dosen ?? null;
        $dosenPembimbing2Id = $mahasiswa->dosenPembimbing2->id_dosen ?? null;

        // Ambil ID dosen wali
        $dosenWaliId = $mahasiswa->id_dosen_wali;

        // Ambil ID dosen yang sudah menjadi penguji untuk mahasiswa ini
        $dosenPengujiIds = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->pluck('id_dosen')
            ->toArray();

        // Ambil dosen yang sudah pernah menguji seminar (dari semua mahasiswa)
        $dosenSudahSeminarIds = DB::table('pengujis')
            ->join('seminars', 'pengujis.id_mahasiswa', '=', 'seminars.id_mahasiswa')
            ->where('seminars.status', 'diterima')
            ->whereIn('seminars.jenis', ['proposal', 'hasil', 'sidang'])
            ->distinct()
            ->pluck('pengujis.id_dosen')
            ->toArray();

        // Ambil dosen yang bukan pembimbing
        $dosenList = Dosen::whereHas('jurusan', function ($query) {
            $query->where('nama_jurusan', 'informatika');
        })
        ->whereNotIn('id_dosen', array_filter([$dosenPembimbing1Id, $dosenPembimbing2Id]))
        ->get()
        ->map(function($dosen) use ($dosenWaliId, $dosenPengujiIds, $dosenSudahSeminarIds) {
            // Tambahkan flag is_wali
            $dosen->is_wali = ($dosen->id_dosen == $dosenWaliId);

            // Tambahkan flag is_current_penguji (sedang menjadi penguji mahasiswa ini)
            $dosen->is_current_penguji = in_array($dosen->id_dosen, $dosenPengujiIds);

            // Tambahkan flag sudah_seminar (pernah menguji seminar yang sudah selesai)
            $dosen->sudah_seminar = in_array($dosen->id_dosen, $dosenSudahSeminarIds);

            // Hitung berapa kali jadi penguji
            $dosen->jumlah_penguji = Penguji::where('id_dosen', $dosen->id_dosen)->count();

            // Hitung berapa kali menguji seminar yang sudah selesai
            $dosen->jumlah_seminar_selesai = \DB::table('pengujis')
                ->join('seminars', 'pengujis.id_mahasiswa', '=', 'seminars.id_mahasiswa')
                ->where('pengujis.id_dosen', $dosen->id_dosen)
                ->where('seminars.status', 'diterima')
                ->whereIn('seminars.jenis', ['proposal', 'hasil', 'sidang'])
                ->count();

            return $dosen;
        })
        ->sortBy([
            // Prioritas 1: Yang sedang menjadi penguji mahasiswa ini (di atas)
            ['is_current_penguji', 'desc'],
            // Prioritas 2: Dosen wali (di atas)
            ['is_wali', 'desc'],
            // Prioritas 3: Yang belum pernah seminar (di atas)
            ['sudah_seminar', 'asc'],
            // Prioritas 4: Yang paling sedikit menguji seminar (di atas)
            ['jumlah_seminar_selesai', 'asc'],
            // Prioritas 5: Yang paling sedikit jadi penguji (di atas)
            ['jumlah_penguji', 'asc'],
            // Prioritas 6: Nama (A-Z)
            ['nama', 'asc']
        ])
        ->values(); // Reset index array

        $pengajuan = $mahasiswa->pengajuan()->first();
        $penguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 1)->first();
        $penguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 2)->first();
        $penguji3 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 3)->first();

        // Ambil data seminar untuk semua jenis
        $seminarProposal = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('jenis', 'proposal')
            ->first();
        $seminarHasil = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('jenis', 'hasil')
            ->first();
        $seminarSidang = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('jenis', 'sidang')
            ->first();

        return view('pengujiadmin', compact(
            'mahasiswa',
            'dosenList',
            'pengajuan',
            'penguji1',
            'penguji2',
            'penguji3',
            'seminarProposal',
            'seminarHasil',
            'seminarSidang'
        ));
    }

    public function show(Request $request, $id){
        $mahasiswa = Mahasiswa::with(['dospem1', 'dospem2'])->where('id_mahasiswa', $id)->first();
        $dosenList = Dosen::all();
        dd($mahasiswa);
        return view('pengujiadmin', compact('mahasiswa', 'dosenList'));
    }

    public function store(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'penguji_1' => 'nullable',
            'penguji_2' => 'nullable',
            'penguji_3' => 'nullable',
        ]);

        // Cek penguji yang sudah ada
        $existingPenguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 1)->first();
        $existingPenguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 2)->first();
        $existingPenguji3 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 3)->first();

        $messages = [];
        $changedPenguji = []; // Track perubahan untuk notifikasi

        // Proses Penguji 1
        if ($request->penguji_1) {
            $dosen1 = Dosen::where('nama', $request->penguji_1)->first();
            if ($dosen1) {
                if ($existingPenguji1) {
                    // Update penguji yang sudah ada
                    $oldDosen = $existingPenguji1->dosen->nama ?? 'Unknown';
                    $existingPenguji1->update(['id_dosen' => $dosen1->id_dosen]);
                    $messages[] = 'Penguji 1 berhasil diperbarui.';

                    if ($oldDosen !== $dosen1->nama) {
                        $changedPenguji[] = [
                            'urutan' => 1,
                            'dosen_baru' => $dosen1->nama,
                            'dosen_lama' => $oldDosen,
                            'action' => 'updated'
                        ];
                    }
                } else {
                    // Tambah penguji baru
                    Penguji::create([
                        'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                        'id_dosen' => $dosen1->id_dosen,
                        'urutan' => 1
                    ]);
                    $messages[] = 'Penguji 1 berhasil ditetapkan.';

                    $changedPenguji[] = [
                        'urutan' => 1,
                        'dosen_baru' => $dosen1->nama,
                        'dosen_lama' => null,
                        'action' => 'assigned'
                    ];
                }
            }
        }

        // Proses Penguji 2
        if ($request->penguji_2) {
            $dosen2 = Dosen::where('nama', $request->penguji_2)->first();
            if ($dosen2) {
                if ($existingPenguji2) {
                    $oldDosen = $existingPenguji2->dosen->nama ?? 'Unknown';
                    $existingPenguji2->update(['id_dosen' => $dosen2->id_dosen]);
                    $messages[] = 'Penguji 2 berhasil diperbarui.';

                    if ($oldDosen !== $dosen2->nama) {
                        $changedPenguji[] = [
                            'urutan' => 2,
                            'dosen_baru' => $dosen2->nama,
                            'dosen_lama' => $oldDosen,
                            'action' => 'updated'
                        ];
                    }
                } else {
                    Penguji::create([
                        'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                        'id_dosen' => $dosen2->id_dosen,
                        'urutan' => 2
                    ]);
                    $messages[] = 'Penguji 2 berhasil ditetapkan.';

                    $changedPenguji[] = [
                        'urutan' => 2,
                        'dosen_baru' => $dosen2->nama,
                        'dosen_lama' => null,
                        'action' => 'assigned'
                    ];
                }
            }
        }

        // Proses Penguji 3
        if ($request->penguji_3) {
            $dosen3 = Dosen::where('nama', $request->penguji_3)->first();
            if ($dosen3) {
                if ($existingPenguji3) {
                    $oldDosen = $existingPenguji3->dosen->nama ?? 'Unknown';
                    $existingPenguji3->update(['id_dosen' => $dosen3->id_dosen]);
                    $messages[] = 'Penguji 3 berhasil diperbarui.';

                    if ($oldDosen !== $dosen3->nama) {
                        $changedPenguji[] = [
                            'urutan' => 3,
                            'dosen_baru' => $dosen3->nama,
                            'dosen_lama' => $oldDosen,
                            'action' => 'updated'
                        ];
                    }
                } else {
                    Penguji::create([
                        'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                        'id_dosen' => $dosen3->id_dosen,
                        'urutan' => 3
                    ]);
                    $messages[] = 'Penguji 3 berhasil ditetapkan.';

                    $changedPenguji[] = [
                        'urutan' => 3,
                        'dosen_baru' => $dosen3->nama,
                        'dosen_lama' => null,
                        'action' => 'assigned'
                    ];
                }
            }
        }

        // Kirim notifikasi ke mahasiswa jika ada perubahan
        if (!empty($changedPenguji)) {
            $this->sendPengujiNotificationToMahasiswa($mahasiswa, $changedPenguji);
        }

        $message = empty($messages) ? 'Tidak ada penguji yang ditetapkan.' : implode(' ', $messages);

        return redirect()->back()->with('success', $message);
    }

    public function reset(Mahasiswa $mahasiswa)
    {
        // Ambil data penguji sebelum dihapus untuk notifikasi
        $existingPenguji = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->with('dosen')
            ->get();

        $resetPenguji = [];
        foreach ($existingPenguji as $penguji) {
            $resetPenguji[] = [
                'urutan' => $penguji->urutan,
                'dosen_nama' => $penguji->dosen->nama ?? 'Unknown',
                'action' => 'removed'
            ];
        }

        // Hapus semua penguji
        Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->delete();

        // Kirim notifikasi ke mahasiswa
        if (!empty($resetPenguji)) {
            $this->sendPengujiResetNotificationToMahasiswa($mahasiswa, $resetPenguji);
        }

        return redirect()->back()->with('success', 'Penguji berhasil direset. Silakan tetapkan ulang.');
    }

    /**
     * Kirim notifikasi ke mahasiswa saat penguji ditetapkan/diubah
     */
    private function sendPengujiNotificationToMahasiswa($mahasiswa, $changedPenguji)
    {
        try {
            // Buat pesan notifikasi yang detail
            $pesanDetail = $this->buildPengujiChangeMessage($changedPenguji);

            // Simpan notifikasi ke database
            Notifikasi::create([
                'id_user' => $mahasiswa->id_mahasiswa,
                'role' => 'mahasiswa',
                'tipe_notifikasi' => 'Penetapan Penguji',
                'pesan' => $pesanDetail,
                'tanggal_kirim' => now(),
                'status_baca' => 'belum'
            ]);

            Log::info('Notifikasi penetapan penguji dikirim ke mahasiswa', [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'mahasiswa_nama' => $mahasiswa->nama,
                'changed_penguji' => $changedPenguji
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi penetapan penguji', [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Kirim notifikasi ke mahasiswa saat penguji direset
     */
    private function sendPengujiResetNotificationToMahasiswa($mahasiswa, $resetPenguji)
    {
        try {
            // Buat pesan untuk reset penguji
            $pesanReset = $this->buildPengujiResetMessage($resetPenguji);

            // Simpan notifikasi ke database
            Notifikasi::create([
                'id_user' => $mahasiswa->id_mahasiswa,
                'role' => 'mahasiswa',
                'tipe_notifikasi' => 'Reset Penguji',
                'pesan' => $pesanReset,
                'tanggal_kirim' => now(),
                'status_baca' => 'belum'
            ]);

            Log::info('Notifikasi reset penguji dikirim ke mahasiswa', [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'mahasiswa_nama' => $mahasiswa->nama,
                'reset_penguji' => $resetPenguji
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi reset penguji', [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Buat pesan notifikasi untuk perubahan penguji
     */
    private function buildPengujiChangeMessage($changedPenguji)
    {
        $messages = [];

        foreach ($changedPenguji as $change) {
            $urutanText = "Penguji " . $change['urutan'];

            if ($change['action'] === 'assigned') {
                $messages[] = "✅ {$urutanText} telah ditetapkan: {$change['dosen_baru']}";
            } elseif ($change['action'] === 'updated') {
                $messages[] = "🔄 {$urutanText} telah diubah dari {$change['dosen_lama']} menjadi {$change['dosen_baru']}";
            }
        }

        $baseMessage = "Penguji Tugas Akhir Anda telah diperbarui oleh admin:";

        return $baseMessage . "\n\n" . implode("\n", $messages) . "\n\nSilakan login ke sistem untuk melihat detail lengkap.";
    }

    /**
     * Buat pesan notifikasi untuk reset penguji
     */
    private function buildPengujiResetMessage($resetPenguji)
    {
        $messages = [];

        foreach ($resetPenguji as $reset) {
            $urutanText = "Penguji " . $reset['urutan'];
            $messages[] = "❌ {$urutanText}: {$reset['dosen_nama']} (dihapus)";
        }

        $baseMessage = "Semua penguji Tugas Akhir Anda telah direset oleh admin:";

        return $baseMessage . "\n\n" . implode("\n", $messages) . "\n\nPenguji baru akan segera ditetapkan. Silakan hubungi admin jika ada pertanyaan.";
    }

    // Update method uploadNilai untuk menambah notifikasi
    public function uploadNilai(Request $request, $mahasiswaId)
    {
        $request->validate([
            'jenis_seminar' => 'required|in:proposal,hasil,sidang',
            'nilai' => 'required|numeric|min:0|max:100',
        ], [
            'jenis_seminar.required' => 'Jenis seminar harus dipilih',
            'jenis_seminar.in' => 'Jenis seminar tidak valid',
            'nilai.required' => 'Nilai wajib diisi',
            'nilai.numeric' => 'Nilai harus berupa angka',
            'nilai.min' => 'Nilai minimal 0',
            'nilai.max' => 'Nilai maksimal 100',
        ]);

        // Check prerequisites before allowing upload/update
        if ($request->jenis_seminar === 'hasil') {
            $semproposal = Seminar::where('id_mahasiswa', $mahasiswaId)
                ->where('jenis', 'proposal')
                ->where('lulus', 1)
                ->first();

            if (!$semproposal) {
                return redirect()->back()->with('error', 'Seminar Proposal harus lulus terlebih dahulu sebelum dapat mengupload nilai Seminar Hasil.');
            }
        }

        if ($request->jenis_seminar === 'sidang') {
            $semhas = Seminar::where('id_mahasiswa', $mahasiswaId)
                ->where('jenis', 'hasil')
                ->where('lulus', 1)
                ->first();

            if (!$semhas) {
                return redirect()->back()->with('error', 'Seminar Hasil harus lulus terlebih dahulu sebelum dapat mengupload nilai Sidang.');
            }
        }

        // Check if seminar record exists
        $existingSeminar = Seminar::where('id_mahasiswa', $mahasiswaId)
            ->where('jenis', $request->jenis_seminar)
            ->first();

        // Auto-determine lulus status based on nilai (>= 57 = lulus, < 57 = tidak lulus)
        $lulus = $request->nilai >= 57 ? 1 : 0;
        $status = $lulus ? 'diterima' : 'ditolak';

        // Prepare data for create or update
        $seminarData = [
            'nilai' => $request->nilai,
            'lulus' => $lulus,
            'status' => $status,
        ];

        if ($existingSeminar) {
            // Update existing seminar record
            $existingSeminar->update($seminarData);
            $action = 'diperbarui';
        } else {
            // Create new seminar record with grade only
            $seminarData = array_merge($seminarData, [
                'id_mahasiswa' => $mahasiswaId,
                'jenis' => $request->jenis_seminar,
                'lampiran' => null,
                'tanggal_seminar' => null,
            ]);

            Seminar::create($seminarData);
            $action = 'disimpan';
        }

        $jenisText = match($request->jenis_seminar) {
            'proposal' => 'Seminar Proposal',
            'hasil' => 'Seminar Hasil',
            'sidang' => 'Sidang'
        };

        $statusText = $lulus ? 'LULUS' : 'TIDAK LULUS';

        // Kirim notifikasi ke mahasiswa tentang nilai
        $this->sendNilaiNotificationToMahasiswa($mahasiswaId, $jenisText, $request->nilai, $statusText, $action);

        return redirect()->back()->with('success', "Nilai {$jenisText} berhasil {$action}. Status: {$statusText} (Nilai: {$request->nilai})");
    }

    /**
     * Kirim notifikasi ke mahasiswa saat nilai diupload
     */
    private function sendNilaiNotificationToMahasiswa($mahasiswaId, $jenisText, $nilai, $statusText, $action)
    {
        try {
            $tipeNotifikasi = $statusText === 'LULUS' ? 'Hasil Nilai Lulus' : 'Hasil Nilai Tidak Lulus';

            $pesan = "📊 Nilai {$jenisText} Anda telah {$action}:\n\n" .
                     "🎯 Nilai: {$nilai}\n" .
                     "📝 Status: {$statusText}\n\n";

            if ($statusText === 'LULUS') {
                $pesan .= "🎉 Selamat! Anda telah lulus {$jenisText}. ";

                if ($jenisText === 'Seminar Proposal') {
                    $pesan .= "Anda dapat melanjutkan ke tahap Seminar Hasil.";
                } elseif ($jenisText === 'Seminar Hasil') {
                    $pesan .= "Anda dapat melanjutkan ke tahap Sidang.";
                } else {
                    $pesan .= "Selamat atas keberhasilan Anda!";
                }
            } else {
                $pesan .= "😔 Maaf, Anda belum lulus {$jenisText}. " .
                         "Silakan hubungi dosen pembimbing untuk konsultasi lebih lanjut.";
            }

            Notifikasi::create([
                'id_user' => $mahasiswaId,
                'role' => 'mahasiswa',
                'tipe_notifikasi' => $tipeNotifikasi,
                'pesan' => $pesan,
                'tanggal_kirim' => now(),
                'status_baca' => 'belum'
            ]);

            Log::info('Notifikasi nilai dikirim ke mahasiswa', [
                'mahasiswa_id' => $mahasiswaId,
                'jenis_seminar' => $jenisText,
                'nilai' => $nilai,
                'status' => $statusText
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi nilai', [
                'mahasiswa_id' => $mahasiswaId,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function hapusNilai(Request $request, $mahasiswaId)
    {
        $request->validate([
            'jenis_seminar' => 'required|in:proposal,hasil,sidang',
            'seminar_id' => 'required|exists:seminars,id_seminar',
        ]);

        $seminar = Seminar::where('id_seminar', $request->seminar_id)
            ->where('id_mahasiswa', $mahasiswaId)
            ->where('jenis', $request->jenis_seminar)
            ->first();

        if (!$seminar) {
            return response()->json([
                'success' => false,
                'message' => 'Data seminar tidak ditemukan.'
            ], 404);
        }

        // Check if this seminar is a prerequisite for other seminars - Fix to use 'lulus' field
        if ($request->jenis_seminar === 'proposal') {
            $semhas = Seminar::where('id_mahasiswa', $mahasiswaId)
                ->where('jenis', 'hasil')
                ->where('lulus', 1) // Changed from 'status' => 'diterima'
                ->first();

            if ($semhas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus nilai Seminar Proposal karena sudah ada Seminar Hasil yang lulus.'
                ], 400);
            }
        }

        if ($request->jenis_seminar === 'hasil') {
            $sidang = Seminar::where('id_mahasiswa', $mahasiswaId)
                ->where('jenis', 'sidang')
                ->where('lulus', 1) // Changed from 'status' => 'diterima'
                ->first();

            if ($sidang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus nilai Seminar Hasil karena sudah ada Sidang yang lulus.'
                ], 400);
            }
        }

        $jenisText = match($request->jenis_seminar) {
            'proposal' => 'Seminar Proposal',
            'hasil' => 'Seminar Hasil',
            'sidang' => 'Sidang'
        };

        // If seminar has only grade data (no file), delete it completely
        // If it has file data, only remove grade data
        if (is_null($seminar->lampiran) && is_null($seminar->tanggal_seminar)) {
            $seminar->delete();
        } else {
            $seminar->update([
                'nilai' => null,
                'lulus' => 0, // Reset lulus to 0
                'status' => 'pending', // Reset to pending when grade is removed
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Nilai {$jenisText} berhasil dihapus."
        ]);
    }
}




// namespace App\Http\Controllers;

// use App\Models\Dosen;
// use App\Models\Mahasiswa;
// use App\Models\Penguji;
// use App\Models\Seminar;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class PengujiAdminController extends Controller
// {
//     public function index(Request $request)
//     {
//         $id = $request->id;
//         $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();

//         // Ambil ID dosen pembimbing
//         $dosenPembimbing1Id = $mahasiswa->dosenPembimbing1->id_dosen ?? null;
//         $dosenPembimbing2Id = $mahasiswa->dosenPembimbing2->id_dosen ?? null;

//         // Ambil ID dosen wali
//         $dosenWaliId = $mahasiswa->id_dosen_wali;

//         // Ambil ID dosen yang sudah menjadi penguji untuk mahasiswa ini
//         $dosenPengujiIds = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
//             ->pluck('id_dosen')
//             ->toArray();

//         // Ambil dosen yang sudah pernah menguji seminar (dari semua mahasiswa)
//         $dosenSudahSeminarIds = DB::table('pengujis')
//             ->join('seminars', 'pengujis.id_mahasiswa', '=', 'seminars.id_mahasiswa')
//             ->where('seminars.status', 'diterima')
//             ->whereIn('seminars.jenis', ['proposal', 'hasil', 'sidang'])
//             ->distinct()
//             ->pluck('pengujis.id_dosen')
//             ->toArray();

//         // Ambil dosen yang bukan pembimbing
//         $dosenList = Dosen::whereHas('jurusan', function ($query) {
//             $query->where('nama_jurusan', 'informatika');
//         })
//         ->whereNotIn('id_dosen', array_filter([$dosenPembimbing1Id, $dosenPembimbing2Id]))
//         ->get()
//         ->map(function($dosen) use ($dosenWaliId, $dosenPengujiIds, $dosenSudahSeminarIds) {
//             // Tambahkan flag is_wali
//             $dosen->is_wali = ($dosen->id_dosen == $dosenWaliId);

//             // Tambahkan flag is_current_penguji (sedang menjadi penguji mahasiswa ini)
//             $dosen->is_current_penguji = in_array($dosen->id_dosen, $dosenPengujiIds);

//             // Tambahkan flag sudah_seminar (pernah menguji seminar yang sudah selesai)
//             $dosen->sudah_seminar = in_array($dosen->id_dosen, $dosenSudahSeminarIds);

//             // Hitung berapa kali jadi penguji
//             $dosen->jumlah_penguji = Penguji::where('id_dosen', $dosen->id_dosen)->count();

//             // Hitung berapa kali menguji seminar yang sudah selesai
//             $dosen->jumlah_seminar_selesai = \DB::table('pengujis')
//                 ->join('seminars', 'pengujis.id_mahasiswa', '=', 'seminars.id_mahasiswa')
//                 ->where('pengujis.id_dosen', $dosen->id_dosen)
//                 ->where('seminars.status', 'diterima')
//                 ->whereIn('seminars.jenis', ['proposal', 'hasil', 'sidang'])
//                 ->count();

//             return $dosen;
//         })
//         ->sortBy([
//             // Prioritas 1: Yang sedang menjadi penguji mahasiswa ini (di atas)
//             ['is_current_penguji', 'desc'],
//             // Prioritas 2: Dosen wali (di atas)
//             ['is_wali', 'desc'],
//             // Prioritas 3: Yang belum pernah seminar (di atas)
//             ['sudah_seminar', 'asc'],
//             // Prioritas 4: Yang paling sedikit menguji seminar (di atas)
//             ['jumlah_seminar_selesai', 'asc'],
//             // Prioritas 5: Yang paling sedikit jadi penguji (di atas)
//             ['jumlah_penguji', 'asc'],
//             // Prioritas 6: Nama (A-Z)
//             ['nama', 'asc']
//         ])
//         ->values(); // Reset index array

//         $pengajuan = $mahasiswa->pengajuan()->first();
//         $penguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 1)->first();
//         $penguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 2)->first();
//         $penguji3 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 3)->first();

//         // Ambil data seminar untuk semua jenis
//         $seminarProposal = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
//             ->where('jenis', 'proposal')
//             ->first();
//         $seminarHasil = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
//             ->where('jenis', 'hasil')
//             ->first();
//         $seminarSidang = Seminar::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
//             ->where('jenis', 'sidang')
//             ->first();

//         return view('pengujiadmin', compact(
//             'mahasiswa',
//             'dosenList',
//             'pengajuan',
//             'penguji1',
//             'penguji2',
//             'penguji3',
//             'seminarProposal',
//             'seminarHasil',
//             'seminarSidang'
//         ));
//     }

//     public function show(Request $request, $id){
//         $mahasiswa = Mahasiswa::with(['dospem1', 'dospem2'])->where('id_mahasiswa', $id)->first();
//         $dosenList = Dosen::all();
//         dd($mahasiswa);
//         return view('pengujiadmin', compact('mahasiswa', 'dosenList'));
//     }

//     public function store(Request $request, Mahasiswa $mahasiswa)
//     {
//         $request->validate([
//             'penguji_1' => 'nullable',
//             'penguji_2' => 'nullable',
//             'penguji_3' => 'nullable',
//         ]);

//         // Cek penguji yang sudah ada
//         $existingPenguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 1)->first();
//         $existingPenguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 2)->first();
//         $existingPenguji3 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 3)->first();

//         $messages = [];

//         // Proses Penguji 1
//         if ($request->penguji_1) {
//             $dosen1 = Dosen::where('nama', $request->penguji_1)->first();
//             if ($dosen1) {
//                 if ($existingPenguji1) {
//                     $existingPenguji1->update(['id_dosen' => $dosen1->id_dosen]);
//                 } else {
//                     Penguji::create([
//                         'id_mahasiswa' => $mahasiswa->id_mahasiswa,
//                         'id_dosen' => $dosen1->id_dosen,
//                         'urutan' => 1
//                     ]);
//                 }
//                 $messages[] = 'Penguji 1 berhasil ditetapkan.';
//             }
//         }

//         // Proses Penguji 2
//         if ($request->penguji_2) {
//             $dosen2 = Dosen::where('nama', $request->penguji_2)->first();
//             if ($dosen2) {
//                 if ($existingPenguji2) {
//                     $existingPenguji2->update(['id_dosen' => $dosen2->id_dosen]);
//                 } else {
//                     Penguji::create([
//                         'id_mahasiswa' => $mahasiswa->id_mahasiswa,
//                         'id_dosen' => $dosen2->id_dosen,
//                         'urutan' => 2
//                     ]);
//                 }
//                 $messages[] = 'Penguji 2 berhasil ditetapkan.';
//             }
//         }

//         // Proses Penguji 3
//         if ($request->penguji_3) {
//             $dosen3 = Dosen::where('nama', $request->penguji_3)->first();
//             if ($dosen3) {
//                 if ($existingPenguji3) {
//                     $existingPenguji3->update(['id_dosen' => $dosen3->id_dosen]);
//                 } else {
//                     Penguji::create([
//                         'id_mahasiswa' => $mahasiswa->id_mahasiswa,
//                         'id_dosen' => $dosen3->id_dosen,
//                         'urutan' => 3
//                     ]);
//                 }
//                 $messages[] = 'Penguji 3 berhasil ditetapkan.';
//             }
//         }

//         $message = empty($messages) ? 'Tidak ada penguji yang ditetapkan.' : implode(' ', $messages);

//         return redirect()->back()->with('success', $message);
//     }

//     public function reset(Mahasiswa $mahasiswa)
//     {
//         Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->delete();

//         return redirect()->back()->with('success', 'Penguji berhasil direset. Silakan tetapkan ulang.');
//     }

//     public function uploadNilai(Request $request, $mahasiswaId)
//     {
//         $request->validate([
//             'jenis_seminar' => 'required|in:proposal,hasil,sidang',
//             'nilai' => 'required|numeric|min:0|max:100',
//         ], [
//             'jenis_seminar.required' => 'Jenis seminar harus dipilih',
//             'jenis_seminar.in' => 'Jenis seminar tidak valid',
//             'nilai.required' => 'Nilai wajib diisi',
//             'nilai.numeric' => 'Nilai harus berupa angka',
//             'nilai.min' => 'Nilai minimal 0',
//             'nilai.max' => 'Nilai maksimal 100',
//         ]);

//         // Check prerequisites before allowing upload/update
//         if ($request->jenis_seminar === 'hasil') {
//             $semproposal = Seminar::where('id_mahasiswa', $mahasiswaId)
//                 ->where('jenis', 'proposal')
//                 ->where('lulus', 1)
//                 ->first();

//             if (!$semproposal) {
//                 return redirect()->back()->with('error', 'Seminar Proposal harus lulus terlebih dahulu sebelum dapat mengupload nilai Seminar Hasil.');
//             }
//         }

//         if ($request->jenis_seminar === 'sidang') {
//             $semhas = Seminar::where('id_mahasiswa', $mahasiswaId)
//                 ->where('jenis', 'hasil')
//                 ->where('lulus', 1)
//                 ->first();

//             if (!$semhas) {
//                 return redirect()->back()->with('error', 'Seminar Hasil harus lulus terlebih dahulu sebelum dapat mengupload nilai Sidang.');
//             }
//         }

//         // Check if seminar record exists
//         $existingSeminar = Seminar::where('id_mahasiswa', $mahasiswaId)
//             ->where('jenis', $request->jenis_seminar)
//             ->first();

//         // Auto-determine lulus status based on nilai (>= 57 = lulus, < 57 = tidak lulus)
//         $lulus = $request->nilai >= 57 ? 1 : 0;
//         $status = $lulus ? 'diterima' : 'ditolak';

//         // Prepare data for create or update
//         $seminarData = [
//             'nilai' => $request->nilai,
//             'lulus' => $lulus,
//             'status' => $status,
//         ];

//         if ($existingSeminar) {
//             // Update existing seminar record
//             $existingSeminar->update($seminarData);
//             $action = 'diperbarui';
//         } else {
//             // Create new seminar record with grade only
//             $seminarData = array_merge($seminarData, [
//                 'id_mahasiswa' => $mahasiswaId,
//                 'jenis' => $request->jenis_seminar,
//                 'lampiran' => null,
//                 'tanggal_seminar' => null,
//             ]);

//             Seminar::create($seminarData);
//             $action = 'disimpan';
//         }

//         $jenisText = match($request->jenis_seminar) {
//             'proposal' => 'Seminar Proposal',
//             'hasil' => 'Seminar Hasil',
//             'sidang' => 'Sidang'
//         };

//         $statusText = $lulus ? 'LULUS' : 'TIDAK LULUS';

//         return redirect()->back()->with('success', "Nilai {$jenisText} berhasil {$action}. Status: {$statusText} (Nilai: {$request->nilai})");
//     }

//     public function hapusNilai(Request $request, $mahasiswaId)
//     {
//         $request->validate([
//             'jenis_seminar' => 'required|in:proposal,hasil,sidang',
//             'seminar_id' => 'required|exists:seminars,id_seminar',
//         ]);

//         $seminar = Seminar::where('id_seminar', $request->seminar_id)
//             ->where('id_mahasiswa', $mahasiswaId)
//             ->where('jenis', $request->jenis_seminar)
//             ->first();

//         if (!$seminar) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Data seminar tidak ditemukan.'
//             ], 404);
//         }

//         // Check if this seminar is a prerequisite for other seminars - Fix to use 'lulus' field
//         if ($request->jenis_seminar === 'proposal') {
//             $semhas = Seminar::where('id_mahasiswa', $mahasiswaId)
//                 ->where('jenis', 'hasil')
//                 ->where('lulus', 1) // Changed from 'status' => 'diterima'
//                 ->first();

//             if ($semhas) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Tidak dapat menghapus nilai Seminar Proposal karena sudah ada Seminar Hasil yang lulus.'
//                 ], 400);
//             }
//         }

//         if ($request->jenis_seminar === 'hasil') {
//             $sidang = Seminar::where('id_mahasiswa', $mahasiswaId)
//                 ->where('jenis', 'sidang')
//                 ->where('lulus', 1) // Changed from 'status' => 'diterima'
//                 ->first();

//             if ($sidang) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Tidak dapat menghapus nilai Seminar Hasil karena sudah ada Sidang yang lulus.'
//                 ], 400);
//             }
//         }

//         $jenisText = match($request->jenis_seminar) {
//             'proposal' => 'Seminar Proposal',
//             'hasil' => 'Seminar Hasil',
//             'sidang' => 'Sidang'
//         };

//         // If seminar has only grade data (no file), delete it completely
//         // If it has file data, only remove grade data
//         if (is_null($seminar->lampiran) && is_null($seminar->tanggal_seminar)) {
//             $seminar->delete();
//         } else {
//             $seminar->update([
//                 'nilai' => null,
//                 'lulus' => 0, // Reset lulus to 0
//                 'status' => 'pending', // Reset to pending when grade is removed
//             ]);
//         }

//         return response()->json([
//             'success' => true,
//             'message' => "Nilai {$jenisText} berhasil dihapus."
//         ]);
//     }
// }



