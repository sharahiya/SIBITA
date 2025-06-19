<?php

namespace App\Http\Middleware;

use App\Models\Pengajuan;
use App\Models\Penguji;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckHasPembimbing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $dosenPembimbing1 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('dosen_ke', 1)->where('status', 'diterima')->first();
        $dosenPembimbing2 = Pengajuan::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('dosen_ke', 2)->where('status', 'diterima')->first();

        $dosenPenguji1 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 1)->first();
        $dosenPenguji2 = Penguji::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->where('urutan', 2)->first();
        // Cek apakah mahasiswa memiliki dosen pembimbing 1 dan 2 yang sudah diterima
        if (!$mahasiswa || !$dosenPembimbing1 || !$dosenPembimbing2 || !$dosenPenguji1 || !$dosenPenguji2) {
            // dd($dosenPenguji2);
            return redirect()->route('pengajuan.required');
        }

        return $next($request);
    }
}
