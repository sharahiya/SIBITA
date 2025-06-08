<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileDosenController extends Controller
{
    public function index()
    {
        $user = Auth::guard('dosen')->user();
        $dosen = Dosen::where('id_dosen', $user->id_dosen)->first();

        // Ambil semua pengajuan yang diterima untuk dosen ini
        $ajuanBimbingan = Pengajuan::where('id_dosen', $dosen->id_dosen)
            ->where('status', 'diterima')
            ->with([
                'mahasiswa',
                'mahasiswa.seminars',
                'mahasiswa.seminars.pengajuanSeminar'
            ])
            ->get();

        // Filter berdasarkan logika yang diperbaiki
        $ajuanBimbingan = $ajuanBimbingan->filter(function ($pengajuan) use ($dosen) {
            $mahasiswa = $pengajuan->mahasiswa;

            // Jika tidak ada seminar, tampilkan (masih bimbingan)
            if ($mahasiswa->seminars->isEmpty()) {
                return true;
            }

            // Filter out mahasiswa yang sudah sidang dan diterima
            $hasSidangDiterima = $mahasiswa->seminars->contains(function ($seminar) {
                return $seminar->jenis === 'sidang' && $seminar->status === 'diterima';
            });

            // Filter out mahasiswa yang pengajuan sidangnya sudah diterima oleh dosen ini
            $hasSidangApprovedByDosen = $mahasiswa->seminars->some(function ($seminar) use ($dosen) {
                if ($seminar->jenis === 'sidang') {
                    return $seminar->pengajuanSeminar->some(function ($pengajuanSeminar) use ($dosen) {
                        return $pengajuanSeminar->id_dosen == $dosen->id_dosen &&
                               $pengajuanSeminar->status == 'diterima';
                    });
                }
                return false;
            });

            // Jika sudah sidang dan diterima ATAU pengajuan sidang sudah diapprove dosen ini, jangan tampilkan
            if ($hasSidangDiterima || $hasSidangApprovedByDosen) {
                return false;
            }

            // Cek apakah ada pengajuan seminar yang diterima oleh dosen ini
            $hasApprovedSeminar = $mahasiswa->seminars->some(function ($seminar) use ($dosen) {
                return $seminar->pengajuanSeminar->some(function ($pengajuanSeminar) use ($dosen) {
                    return $pengajuanSeminar->id_dosen == $dosen->id_dosen &&
                           $pengajuanSeminar->status == 'diterima';
                });
            });

            // Tampilkan jika: belum ada seminar ATAU ada pengajuan seminar yang diterima
            return $hasApprovedSeminar || $mahasiswa->seminars->isEmpty();
        });

        $jumlahMahasiswa = $ajuanBimbingan->count();

        // Set seminar status untuk setiap mahasiswa
        $ajuanBimbingan->each(function ($pengajuan) use ($dosen) {
            $mahasiswa = $pengajuan->mahasiswa;
            $seminars = $mahasiswa->seminars;

            // Default status
            $pengajuan->mahasiswa->seminar_status = 'Bimbingan';

            if ($seminars->isNotEmpty()) {
                // Cari pengajuan seminar yang diterima oleh dosen ini
                $approvedProposal = false;
                $approvedHasil = false;
                $approvedSidang = false;
                $completedProposal = false;
                $completedHasil = false;
                $completedSidang = false;

                foreach ($seminars as $seminar) {
                    // Cek pengajuan yang diterima dosen
                    $pengajuanDiterima = $seminar->pengajuanSeminar->where('id_dosen', $dosen->id_dosen)
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

                    // Cek seminar yang sudah selesai
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

                // Tentukan status berdasarkan prioritas
                if ($completedSidang || $approvedSidang) {
                    $pengajuan->mahasiswa->seminar_status = 'Sidang';
                } elseif ($completedHasil) {
                    $pengajuan->mahasiswa->seminar_status = 'Semhas Selesai';
                } elseif ($approvedHasil) {
                    $pengajuan->mahasiswa->seminar_status = 'Semhas';
                } elseif ($completedProposal) {
                    $pengajuan->mahasiswa->seminar_status = 'Sempro Selesai';
                } elseif ($approvedProposal) {
                    $pengajuan->mahasiswa->seminar_status = 'Sempro';
                }
            }
        });

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

        // Buat Notifikasi untuk mahasiswa
        $idDosen = Auth::guard('dosen')->user()->id_dosen;
        Notifikasi::create([
            'id_user' => $pengajuan->id_mahasiswa,
            'role' => 'mahasiswa',
            'tipe_notifikasi' => 'Bimbingan Dihapus',
            'pesan' => 'Status Bimbingan Anda telah dihapus oleh Dosen ' . Auth::guard('dosen')->user()->nama . '.',
            'tanggal_kirim' => now(),
            'status_baca' => 'belum',
        ]);

        // update bimbingan
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
