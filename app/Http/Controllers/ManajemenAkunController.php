<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManajemenAkunController extends Controller
{
    public function index()
    {
        return view('manajemenakun');
    }
    public function uploadMahasiswa(Request $request)
    {
        $file = $request->file('csv');
        $data = array_map('str_getcsv', file($file));
        unset($data[0]); // Buang header

        foreach ($data as $row) {
            Mahasiswa::updateOrCreate(
                ['npm' => $row[1]],
                [
                    'nama' => $row[0],
                    'npm' => $row[1],
                    'email' => $row[2],
                    'angkatan' => $row[3],
                    'nip_dosenwali' => $row[4],
                    'password' => Hash::make($row[1]), // Menggunakan npm sebagai password
                ]
            );
        }

        return response()->json(['message' => 'Data mahasiswa berhasil diupload.']);
    }

    public function uploadDosen(Request $request)
    {
        $file = $request->file('csv');
        $data = array_map('str_getcsv', file($file));
        unset($data[0]);

        foreach ($data as $row) {
            Dosen::updateOrCreate(
                ['nip' => $row[1]],
                [
                    'nama' => $row[0],
                    'email' => $row[2],
                    'jabatan' => $row[3],
                    'password' => Hash::make($row[1]), // Menggunakan nip sebagai password
                    'bidang' => $row[4],

                ]
            );
        }

        return response()->json(['message' => 'Data dosen berhasil diupload.']);
    }
}
