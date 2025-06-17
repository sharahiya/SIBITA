<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Penguji;
use App\Models\Seminar;
use Illuminate\Http\Request;

class PengujiAdminController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();

        // Ambil ID dosen pembimbing
        $dosenPembimbing1Id = $mahasiswa->dosenPembimbing1->id_dosen ?? null;
        $dosenPembimbing2Id = $mahasiswa->dosenPembimbing2->id_dosen ?? null;

        // Ambil dosen yang bukan pembimbing
        $dosenList = Dosen::whereHas('jurusan', function ($query) {
            $query->where('nama_jurusan', 'informatika');
        })
        ->whereNotIn('id_dosen', array_filter([$dosenPembimbing1Id, $dosenPembimbing2Id]))
        ->get();

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

        // Proses Penguji 1
        if ($request->penguji_1) {
            $dosen1 = Dosen::where('nama', $request->penguji_1)->first();
            if ($dosen1) {
                if ($existingPenguji1) {
                    $existingPenguji1->update(['id_dosen' => $dosen1->id_dosen]);
                } else {
                    Penguji::create([
                        'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                        'id_dosen' => $dosen1->id_dosen,
                        'urutan' => 1
                    ]);
                }
                $messages[] = 'Penguji 1 berhasil ditetapkan.';
            }
        }

        // Proses Penguji 2
        if ($request->penguji_2) {
            $dosen2 = Dosen::where('nama', $request->penguji_2)->first();
            if ($dosen2) {
                if ($existingPenguji2) {
                    $existingPenguji2->update(['id_dosen' => $dosen2->id_dosen]);
                } else {
                    Penguji::create([
                        'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                        'id_dosen' => $dosen2->id_dosen,
                        'urutan' => 2
                    ]);
                }
                $messages[] = 'Penguji 2 berhasil ditetapkan.';
            }
        }

        // Proses Penguji 3
        if ($request->penguji_3) {
            $dosen3 = Dosen::where('nama', $request->penguji_3)->first();
            if ($dosen3) {
                if ($existingPenguji3) {
                    $existingPenguji3->update(['id_dosen' => $dosen3->id_dosen]);
                } else {
                    Penguji::create([
                        'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                        'id_dosen' => $dosen3->id_dosen,
                        'urutan' => 3
                    ]);
                }
                $messages[] = 'Penguji 3 berhasil ditetapkan.';
            }
        }

        $message = empty($messages) ? 'Tidak ada penguji yang ditetapkan.' : implode(' ', $messages);

        return redirect()->back()->with('success', $message);
    }

    public function reset(Mahasiswa $mahasiswa)
    {
        Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->delete();

        return redirect()->back()->with('success', 'Penguji berhasil direset. Silakan tetapkan ulang.');
    }

    public function uploadNilai(Request $request, $mahasiswaId)
    {
        $request->validate([
            'jenis_seminar' => 'required|in:proposal,hasil,sidang',
            'nilai' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:lulus,tidak_lulus',
        ], [
            'jenis_seminar.required' => 'Jenis seminar harus dipilih',
            'jenis_seminar.in' => 'Jenis seminar tidak valid',
            'nilai.required' => 'Nilai wajib diisi',
            'nilai.numeric' => 'Nilai harus berupa angka',
            'nilai.min' => 'Nilai minimal 0',
            'nilai.max' => 'Nilai maksimal 100',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        // Check prerequisites before allowing upload/update - Fix to use 'lulus' field
        if ($request->jenis_seminar === 'hasil') {
            $semproposal = Seminar::where('id_mahasiswa', $mahasiswaId)
                ->where('jenis', 'proposal')
                ->where('lulus', 1) // Changed from 'status' => 'diterima'
                ->first();

            if (!$semproposal) {
                return redirect()->back()->with('error', 'Seminar Proposal harus lulus terlebih dahulu sebelum dapat mengupload nilai Seminar Hasil.');
            }
        }

        if ($request->jenis_seminar === 'sidang') {
            $semhas = Seminar::where('id_mahasiswa', $mahasiswaId)
                ->where('jenis', 'hasil')
                ->where('lulus', 1) // Changed from 'status' => 'diterima'
                ->first();

            if (!$semhas) {
                return redirect()->back()->with('error', 'Seminar Hasil harus lulus terlebih dahulu sebelum dapat mengupload nilai Sidang.');
            }
        }

        // Check if seminar record exists
        $existingSeminar = Seminar::where('id_mahasiswa', $mahasiswaId)
            ->where('jenis', $request->jenis_seminar)
            ->first();

        // Prepare data for create or update
        $seminarData = [
            'nilai' => $request->nilai,
            'lulus' => $request->status === 'lulus' ? 1 : 0,
            // 'status' => $request->status === 'lulus' ? 'diterima' : 'ditolak', // Uncommented this line
        ];

        if ($existingSeminar) {
            // Update existing seminar record
            $existingSeminar->update($seminarData);
            $action = 'diperbarui';
        } else {
            // Create new seminar record with grade only (no file yet)
            $seminarData = array_merge($seminarData, [
                'id_mahasiswa' => $mahasiswaId,
                'jenis' => $request->jenis_seminar,
                'lampiran' => null, // Will be filled when student uploads file
                'tanggal_seminar' => null, // Will be filled when student uploads file
            ]);

            Seminar::create($seminarData);
            $action = 'disimpan';
        }

        $jenisText = match($request->jenis_seminar) {
            'proposal' => 'Seminar Proposal',
            'hasil' => 'Seminar Hasil',
            'sidang' => 'Sidang'
        };

        return redirect()->back()->with('success', "Nilai {$jenisText} berhasil {$action}.");
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
