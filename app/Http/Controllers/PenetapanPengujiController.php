<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Penguji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenetapanPengujiController extends Controller
{
    /**
     * Tambah penguji 3 (opsional) untuk mahasiswa yang sudah memiliki penguji 1 dan 2
     */
    public function tambahPenguji3(Request $request, $mahasiswaId)
    {
        // Find mahasiswa by ID
        $mahasiswa = Mahasiswa::findOrFail($mahasiswaId);

        // Validasi input
        $request->validate([
            'penguji_3' => 'required|string|min:1',
        ], [
            'penguji_3.required' => 'Penguji 3 harus dipilih',
            'penguji_3.string' => 'Format nama penguji tidak valid',
            'penguji_3.min' => 'Nama penguji tidak boleh kosong',
        ]);

        try {
            DB::beginTransaction();

            // Log input for debugging
            Log::info('Attempting to add penguji 3', [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'penguji_3' => $request->penguji_3,
                'request_all' => $request->all()
            ]);


            // Cek apakah sudah ada penguji 3
            $existingPenguji3 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                                      ->where('urutan', 3)
                                      ->first();

            if ($existingPenguji3) {
                Log::warning('Penguji 3 already exists', [
                    'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                    'existing_penguji3_id' => $existingPenguji3->id_penguji
                ]);
                return redirect()->back()->with('error', 'Mahasiswa sudah memiliki Penguji 3.');
            }

            // Cari dosen berdasarkan nama (case-insensitive)
            $dosen3 = Dosen::whereRaw('LOWER(nama) = ?', [strtolower(trim($request->penguji_3))])->first();

            if (!$dosen3) {
                Log::error('Dosen not found', [
                    'searched_name' => $request->penguji_3,
                    'available_dosen' => Dosen::pluck('nama')->toArray()
                ]);
                return redirect()->back()->with('error', 'Dosen yang dipilih tidak ditemukan: ' . $request->penguji_3);
            }

        

            // Validasi dosen tidak boleh menjadi pembimbing mahasiswa tersebut
            $dosenPembimbing1Id = optional($mahasiswa->dosenPembimbing1)->id_dosen;
            $dosenPembimbing2Id = optional($mahasiswa->dosenPembimbing2)->id_dosen;

            if ($dosen3->id_dosen === $dosenPembimbing1Id || $dosen3->id_dosen === $dosenPembimbing2Id) {
                Log::warning('Supervisor cannot be examiner', [
                    'dosen3_id' => $dosen3->id_dosen,
                    'pembimbing1_id' => $dosenPembimbing1Id,
                    'pembimbing2_id' => $dosenPembimbing2Id
                ]);
                return redirect()->back()->with('error', 'Dosen pembimbing tidak dapat menjadi penguji.');
            }

            // Simpan penguji 3
            $newPenguji3 = Penguji::create([
                'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                'id_dosen' => $dosen3->id_dosen,
                'urutan' => 3
            ]);

            Log::info('Penguji 3 created successfully', [
                'penguji_id' => $newPenguji3->id_penguji,
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'dosen_id' => $dosen3->id_dosen,
                'dosen_name' => $dosen3->nama
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Penguji 3 (' . $dosen3->nama . ') berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();

            // Log error untuk debugging
            Log::error('Error adding penguji 3: ' . $e->getMessage(), [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'penguji_3' => $request->penguji_3,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan Penguji 3: ' . $e->getMessage());
        }
    }

    /**
     * Hapus penguji 3 dari mahasiswa
     */
    public function hapusPenguji3(Request $request, $mahasiswaId)
    {
        $mahasiswa = Mahasiswa::findOrFail($mahasiswaId);

        try {
            DB::beginTransaction();

            $penguji3 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                              ->where('urutan', 3)
                              ->first();

            if (!$penguji3) {
                return redirect()->back()->with('error', 'Mahasiswa tidak memiliki Penguji 3.');
            }

            $namaDosenPenguji3 = $penguji3->dosen->nama;
            $penguji3->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Penguji 3 (' . $namaDosenPenguji3 . ') berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error removing penguji 3: ' . $e->getMessage(), [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus Penguji 3. Silakan coba lagi.');
        }
    }

    /**
     * Update penguji 3 (mengganti dengan dosen lain)
     */
    public function updatePenguji3(Request $request, $mahasiswaId)
    {
        $mahasiswa = Mahasiswa::findOrFail($mahasiswaId);

        $request->validate([
            'penguji_3' => 'required|string',
        ], [
            'penguji_3.required' => 'Penguji 3 harus dipilih',
            'penguji_3.string' => 'Format nama penguji tidak valid',
        ]);

        try {
            DB::beginTransaction();

            $penguji3 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                              ->where('urutan', 3)
                              ->first();

            if (!$penguji3) {
                return redirect()->back()->with('error', 'Mahasiswa tidak memiliki Penguji 3.');
            }

            // Cari dosen baru
            $dosenBaru = Dosen::whereRaw('LOWER(nama) = ?', [strtolower(trim($request->penguji_3))])->first();

            if (!$dosenBaru) {
                return redirect()->back()->with('error', 'Dosen yang dipilih tidak ditemukan.');
            }

            // Ambil penguji 1 dan 2 untuk validasi
            $penguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                              ->where('urutan', 1)
                              ->first();

            $penguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                              ->where('urutan', 2)
                              ->first();

            // Validasi tidak boleh sama dengan penguji lain
            if ($dosenBaru->id_dosen === $penguji1->id_dosen || $dosenBaru->id_dosen === $penguji2->id_dosen) {
                return redirect()->back()->with('error', 'Penguji 3 tidak boleh sama dengan Penguji 1 atau Penguji 2.');
            }

            // Validasi tidak boleh menjadi pembimbing
            $dosenPembimbing1Id = optional($mahasiswa->dosenPembimbing1)->id_dosen;
            $dosenPembimbing2Id = optional($mahasiswa->dosenPembimbing2)->id_dosen;

            if ($dosenBaru->id_dosen === $dosenPembimbing1Id || $dosenBaru->id_dosen === $dosenPembimbing2Id) {
                return redirect()->back()->with('error', 'Dosen pembimbing tidak dapat menjadi penguji.');
            }

            $namaDosenLama = $penguji3->dosen->nama;

            // Update penguji 3
            $penguji3->update([
                'id_dosen' => $dosenBaru->id_dosen
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Penguji 3 berhasil diubah dari ' . $namaDosenLama . ' ke ' . $dosenBaru->nama . '.');

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error updating penguji 3: ' . $e->getMessage(), [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'penguji_3' => $request->penguji_3,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah Penguji 3. Silakan coba lagi.');
        }
    }

    /**
     * Get available lecturers for penguji 3 (excluding pembimbing and existing penguji)
     */
    public function getAvailableLecturers($mahasiswaId)
    {
        $mahasiswa = Mahasiswa::findOrFail($mahasiswaId);

        try {
            // Get pembimbing IDs
            $dosenPembimbing1Id = optional($mahasiswa->dosenPembimbing1)->id_dosen;
            $dosenPembimbing2Id = optional($mahasiswa->dosenPembimbing2)->id_dosen;

            // Get existing penguji IDs
            $existingPengujiIds = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                                        ->pluck('id_dosen')
                                        ->toArray();

            // Combine all IDs to exclude
            $excludeIds = array_filter(array_merge(
                [$dosenPembimbing1Id, $dosenPembimbing2Id],
                $existingPengujiIds
            ));

            // Get available lecturers
            $availableLecturers = Dosen::whereHas('jurusan', function ($query) {
                $query->where('nama_jurusan', 'informatika');
            })
            ->whereNotIn('id_dosen', $excludeIds)
            ->select('id_dosen', 'nama', 'nip', 'jabatan')
            ->orderBy('nama')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $availableLecturers
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting available lecturers: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data dosen.'
            ], 500);
        }
    }
}
