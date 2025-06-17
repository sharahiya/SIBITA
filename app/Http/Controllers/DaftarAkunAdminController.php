<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DaftarAkunAdminController extends Controller
{
    public function index()
    {
        // Ambil data mahasiswa dengan relasi dosen wali
        $mahasiswas = Mahasiswa::with('dosenWali')->get();

        // Ambil data dosen
        $dosens = Dosen::all();

        return view('daftarakunadmin', compact('mahasiswas', 'dosens'));
    }

    public function getDosenDetail($id)
    {
        try {
            $dosen = Dosen::findOrFail($id);

            // Get supervised students from approved pengajuan
            $mahasiswaBimbingan = Pengajuan::where('id_dosen', $id)
                ->where('status', 'diterima')
                ->with(['mahasiswa' => function($query) {
                    $query->select('id_mahasiswa', 'nama', 'npm', 'angkatan');
                }])
                ->get()
                ->unique('id_mahasiswa')
                ->map(function($pengajuan) {
                    return [
                        'nama' => $pengajuan->mahasiswa->nama,
                        'npm' => $pengajuan->mahasiswa->npm,
                        'angkatan' => $pengajuan->mahasiswa->angkatan,
                        'dosen_ke' => $pengajuan->dosen_ke,
                        'topik_ta' => $pengajuan->topik_ta,
                        'bidang' => $pengajuan->bidang,
                        'tanggal_pengajuan' => $pengajuan->created_at
                    ];
                });

            // Get students under supervision (dosen wali)
            $mahasiswaWali = Mahasiswa::where('id_dosen_wali', $id)
                ->select('nama', 'npm', 'angkatan')
                ->get()
                ->map(function($mahasiswa) {
                    return [
                        'nama' => $mahasiswa->nama,
                        'npm' => $mahasiswa->npm,
                        'angkatan' => $mahasiswa->angkatan
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
                        'jumlah_bimbingan_aktif' => $dosen->jumlahMahasiswaBimbingan(),
                        'jumlah_mahasiswa_wali' => $dosen->jumlahMahasiswaPerwalian(),
                        'jumlah_penguji' => $dosen->jumlahMenjadiPenguji()
                    ],
                    'mahasiswa_bimbingan' => $mahasiswaBimbingan->values(),
                    'mahasiswa_wali' => $mahasiswaWali->values()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data dosen'
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
}
