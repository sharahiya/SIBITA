<?php

namespace App\Http\Middleware;

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

        if (!$mahasiswa || !$mahasiswa->dosen_pembimbing1 && !$mahasiswa->dosen_pembimbing2) {
            return redirect()->route('pengajuan.required');
        }

        return $next($request);
    }
}
