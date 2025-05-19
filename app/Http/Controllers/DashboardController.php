<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('dashboard', [
            'mahasiswa' => $mahasiswa,
            'dospem1' => null,
            'dospem2' => null,
            'penguji1' => null,
            'penguji2' => null,
            'status' => [
                ['tanggal' => '2024-01-18', 'judul' => 'Pengajuan Bimbingan', 'deskripsi' => 'Selamat Pengajuan Anda Diterima!'],
                ['tanggal' => '2024-03-21', 'judul' => 'Seminar Proposal', 'deskripsi' => 'Selamat Pengajuan Anda Diterima!'],
                ['tanggal' => '2024-04-28', 'judul' => 'Seminar Hasil', 'deskripsi' => 'Selamat Pengajuan Anda Diterima!'],
                ['tanggal' => '2024-05-30', 'judul' => 'Sidang', 'deskripsi' => 'Selamat Pengajuan Anda Diterima!'],
            ]
    ]);
    }
}
