<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Penguji;
use Illuminate\Http\Request;

class DaftarAkunAdminController extends Controller
{
    public function index()
    {
        // Ambil data mahasiswa dengan relasi dosen wali
        $mahasiswas = Mahasiswa::with('dosenWali')->get();

        // Ambil data dosen dengan jumlah bimbingan aktif
        $dosens = Dosen::all();

        // Add active guidance count for each dosen
        foreach($dosens as $dosen) {
            $result = ProfileDosenController::getDaftarMahasiswaBimbingan($dosen->id_dosen, true);
            $dosen->jumlah_bimbingan_aktif = $result['jumlahMahasiswa'];
        }

        return view('daftarakunadmin', compact('mahasiswas', 'dosens'));
    }

    public function getDosenDetail($id)
    {
        try {
            $dosen = Dosen::findOrFail($id);

            // Use the reusable function to get supervised students (excluding graduated ones)
            $result = ProfileDosenController::getDaftarMahasiswaBimbingan($id, true);
            $ajuanBimbingan = $result['ajuanBimbingan'];

            // Transform the data for response with proper seminar status
            $mahasiswaBimbingan = $ajuanBimbingan->map(function($pengajuan) {
                $mahasiswa = $pengajuan->mahasiswa;

                // Get seminar status using the accessor
                $seminarStatus = $mahasiswa->seminar_status;

                return [
                    'nama' => $mahasiswa->nama,
                    'npm' => $mahasiswa->npm,
                    'angkatan' => $mahasiswa->angkatan,
                    'dosen_ke' => $pengajuan->dosen_ke,
                    'topik_ta' => $pengajuan->topik_ta,
                    'bidang' => $pengajuan->bidang,
                    'tanggal_pengajuan' => $pengajuan->created_at,
                    'seminar_status' => $seminarStatus,
                    'status' => $seminarStatus
                ];
            });

            // Get students under supervision (dosen wali) with their seminar status
            $mahasiswaWali = Mahasiswa::where('id_dosen_wali', $id)
                ->get()
                ->map(function($mahasiswa) {
                    // Use the seminar status accessor
                    $seminarStatus = $mahasiswa->seminar_status;

                    return [
                        'nama' => $mahasiswa->nama,
                        'npm' => $mahasiswa->npm,
                        'angkatan' => $mahasiswa->angkatan,
                        'seminar_status' => $seminarStatus,
                        'status' => $seminarStatus
                    ];
                });

            // Get students where this dosen is examiner (penguji) - ONLY those who haven't completed sidang
            $mahasiswaPenguji = Penguji::where('id_dosen', $id)
                ->with([
                    'mahasiswa' => function($query) {
                        // Only get mahasiswa who haven't completed sidang (status != 'diterima' for sidang)
                        $query->whereDoesntHave('seminars', function($seminarQuery) {
                            $seminarQuery->where('jenis', 'sidang')
                                       ->where('status', 'diterima');
                        });
                    },
                    'mahasiswa.pengajuan' => function($query) {
                        $query->where('status', 'diterima')->with('dosen');
                    },
                    'mahasiswa.seminars' => function($query) {
                        $query->where('status', 'diterima')->orderBy('created_at', 'desc');
                    }
                ])
                ->get()
                ->filter(function($penguji) {
                    // Additional filter to ensure mahasiswa exists (in case whereDoesntHave didn't work as expected)
                    return $penguji->mahasiswa !== null;
                })
                ->map(function($penguji) {
                    $mahasiswa = $penguji->mahasiswa;

                    // Get the latest seminar status
                    $latestSeminar = $mahasiswa->seminars->first();
                    $seminarStatus = 'Bimbingan';

                    if ($latestSeminar) {
                        switch ($latestSeminar->jenis) {
                            case 'proposal':
                                $seminarStatus = 'Sempro';
                                break;
                            case 'hasil':
                                $seminarStatus = 'Semhas';
                                break;
                            case 'sidang':
                                $seminarStatus = 'Sidang';
                                break;
                            default:
                                $seminarStatus = 'Bimbingan';
                        }
                    }

                    // Get pembimbing info
                    $pembimbing = $mahasiswa->pengajuan->where('status', 'diterima');
                    $pembimbingList = [];
                    foreach($pembimbing as $p) {
                        $pembimbingList[] = [
                            'nama' => $p->dosen->nama,
                            'dosen_ke' => $p->dosen_ke
                        ];
                    }

                    return [
                        'nama' => $mahasiswa->nama,
                        'npm' => $mahasiswa->npm,
                        'angkatan' => $mahasiswa->angkatan,
                        'urutan_penguji' => $penguji->urutan,
                        'role_penguji' => $this->getPengujiRole($penguji->urutan),
                        'seminar_status' => $seminarStatus,
                        'status' => $seminarStatus,
                        'pembimbing' => $pembimbingList,
                        'topik_ta' => $pembimbing->first()->topik_ta ?? 'Belum ada topik',
                        'created_at' => $penguji->created_at
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'dosen' => [
                        'nama' => $dosen->nama,
                        'nip' => $dosen->nip,
                        'bidang' => $dosen->bidang,
                        'kuota_bimbingan' => $dosen->kuota_bimbingan ?? 0,
                        'jumlah_bimbingan_aktif' => $result['jumlahMahasiswa'],
                        'jumlah_mahasiswa_wali' => $dosen->jumlahMahasiswaPerwalian(),
                        'jumlah_penguji' => $mahasiswaPenguji->count(), // Use actual count from filtered data
                        'jabatan' => $dosen->jabatan,
                        'jurusan' => $dosen->jurusan ? $dosen->jurusan->nama_jurusan : 'Tidak diketahui',
                        'fakultas' => $dosen->fakultas ? $dosen->fakultas->nama_fakultas : 'Tidak diketahui',
                    ],
                    'mahasiswa_bimbingan' => $mahasiswaBimbingan->values(),
                    'mahasiswa_wali' => $mahasiswaWali->values(),
                    'mahasiswa_penguji' => $mahasiswaPenguji->values()
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getDosenDetail: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data dosen: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateKuota(Request $request)
    {
        try {
            $request->validate([
                'dosen_id' => 'required|exists:dosens,id_dosen',
                'kuota_bimbingan' => 'required|integer|min:0|max:50'
            ], [
                'dosen_id.required' => 'ID Dosen wajib diisi',
                'dosen_id.exists' => 'Dosen tidak ditemukan',
                'kuota_bimbingan.required' => 'Kuota bimbingan wajib diisi',
                'kuota_bimbingan.integer' => 'Kuota bimbingan harus berupa angka',
                'kuota_bimbingan.min' => 'Kuota bimbingan minimal 0',
                'kuota_bimbingan.max' => 'Kuota bimbingan maksimal 50'
            ]);

            $dosen = Dosen::findOrFail($request->dosen_id);

            // Update kuota
            $dosen->update([
                'kuota_bimbingan' => $request->kuota_bimbingan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kuota bimbingan berhasil diperbarui',
                'data' => [
                    'dosen_id' => $dosen->id_dosen,
                    'kuota_bimbingan' => $dosen->kuota_bimbingan
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kuota'
            ], 500);
        }
    }

    // Method untuk menampilkan daftar akun
    public function daftarAkun()
    {
        $mahasiswas = Mahasiswa::with('dosenWali')->orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama')->get();

        return view('daftarakunadmin', compact('mahasiswas', 'dosens'));
    }

    private function getUjianType($jenis)
    {
        switch ($jenis) {
            case 'proposal':
                return 'Seminar Proposal';
            case 'hasil':
                return 'Seminar Hasil';
            case 'sidang':
                return 'Sidang';
            default:
                return ucfirst($jenis);
        }
    }

    private function getPengujiRole($urutan)
    {
        switch ($urutan) {
            case 1:
                return 'Penguji 1';
            case 2:
                return 'Penguji 2';
            case 3:
                return 'Penguji 3';
            default:
                return 'Penguji ' . $urutan;
        }
    }
}
