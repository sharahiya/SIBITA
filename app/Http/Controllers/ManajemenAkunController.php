<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManajemenAkunController extends Controller
{
    public function index()
    {
        return view('manajemenakun');
    }

    public function uploadMahasiswa(Request $request)
    {
        try {
            $request->validate([
                'csv' => 'required|file|mimes:csv,txt'
            ]);

            $file = $request->file('csv');
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($data); // Buang header

            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($data as $index => $row) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) continue;

                    if (count($row) < 5) {
                        $errors[] = "Baris " . ($index + 2) . ": Data tidak lengkap";
                        $errorCount++;
                        continue;
                    }

                    // Clean data
                    $nama = trim($row[0]);
                    $npm = trim($row[1]);
                    $email = trim($row[2]);
                    $angkatan = trim($row[3]);
                    $nip_dosenwali = trim($row[4]);

                    // Validate required fields
                    if (empty($nama) || empty($npm) || empty($email)) {
                        $errors[] = "Baris " . ($index + 2) . ": Nama, NPM, dan Email wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    // Cek apakah mahasiswa sudah ada
                    $existing = Mahasiswa::where('npm', $npm)->first();
                    if ($existing) {
                        // Update data yang sudah ada
                        $dosenWaliId = null;
                        if (!empty($nip_dosenwali)) {
                            $dosenWali = Dosen::where('nip', $nip_dosenwali)->first();
                            if (!$dosenWali) {
                                $errors[] = "Baris " . ($index + 2) . ": Tidak ada dosen dengan NIP {$nip_dosenwali}";
                                $errorCount++;
                                continue;
                            }
                            $dosenWaliId = $dosenWali->id_dosen;
                        }

                        $existing->update([
                            'nama' => $nama,
                            'email' => $email,
                            'angkatan' => $angkatan,
                            'id_dosen_wali' => $dosenWaliId,
                        ]);
                    } else {
                        // Buat data baru
                        $dosenWaliId = null;
                        if (!empty($nip_dosenwali)) {
                            $dosenWali = Dosen::where('nip', $nip_dosenwali)->first();
                            if (!$dosenWali) {
                                $errors[] = "Baris " . ($index + 2) . ": Tidak ada dosen dengan NIP {$nip_dosenwali}";
                                $errorCount++;
                                continue;
                            }
                            $dosenWaliId = $dosenWali->id_dosen;
                        }

                        Mahasiswa::create([
                            'npm' => $npm,
                            'nama' => $nama,
                            'email' => $email,
                            'angkatan' => $angkatan,
                            'id_dosen_wali' => $dosenWaliId,
                            'password' => Hash::make($npm), // Default password = NPM
                        ]);
                    }

                    $successCount++;

                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                    $errorCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Upload selesai. {$successCount} berhasil, {$errorCount} gagal.",
                'errors' => $errors,
                'success_count' => $successCount,
                'error_count' => $errorCount
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Upload mahasiswa error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadDosen(Request $request)
    {
        try {
            $request->validate([
                'csv' => 'required|file|mimes:csv,txt'
            ]);

            $file = $request->file('csv');
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($data); // Buang header

            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($data as $index => $row) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) continue;

                    if (count($row) < 5) {
                        $errors[] = "Baris " . ($index + 2) . ": Data tidak lengkap";
                        $errorCount++;
                        continue;
                    }

                    // Clean data
                    $nama = trim($row[0]);
                    $nip = trim($row[1]);
                    $email = trim($row[2]);
                    $jabatan = trim($row[3]);
                    $bidang = trim($row[4]);
                    $jurusan = trim($row[5] ?? '');


                    // Validate required fields
                    if (empty($nama) || empty($nip)) {
                        $errors[] = "Baris " . ($index + 2) . ": Nama dan NIP wajib diisi";
                        $errorCount++;
                        continue;
                    }

                    // cek apakah jurusan ada
                    $jurusanData = Jurusan::with('fakultas')->where('nama_jurusan', $jurusan)->first();
                    if (!$jurusanData) {
                        $errors[] = "Baris " . ($index + 2) . ": Jurusan '{$jurusan}' tidak ditemukan";
                        $errorCount++;
                        continue;
                    }

                    // Update atau create dosen (hanya field yang ada di fillable)
                    Dosen::updateOrCreate(
                        ['nip' => $nip],
                        [
                            'nama' => $nama,
                            'bidang' => $bidang,
                            'kuota_bimbingan' => 10, // Default kuota
                            'password' => Hash::make($nip), // Default password = NIP
                            'id_jurusan' => $jurusanData->id,
                            'id_fakultas' => $jurusanData->fakultas->id,
                            // email dan jabatan tidak disimpan karena tidak ada di fillable
                        ]
                    );

                    $successCount++;

                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                    $errorCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Upload selesai. {$successCount} berhasil, {$errorCount} gagal.",
                'errors' => $errors,
                'success_count' => $successCount,
                'error_count' => $errorCount
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Upload dosen error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getExistingData()
    {
        try {
            $mahasiswa = Mahasiswa::select('npm', 'email')->get();
            $dosen = Dosen::select('nip')->get();
            $jurusan = Jurusan::with('fakultas')->select('id', 'nama_jurusan', 'id_fakultas')->get();

            return response()->json([
                'mahasiswa' => $mahasiswa,
                'dosen' => $dosen,
                'jurusan' => $jurusan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mahasiswa' => [],
                'dosen' => [],
                'jurusan' => [],
            ]);
        }
    }
}
