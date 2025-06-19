<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiDosenController extends Controller
{
    public function index()
    {
        $userId = Auth::guard('dosen')->user()->id_dosen;
        $role = 'dosen';

        $notifikasis = Notifikasi::where('id_user', $userId)
                                ->where('role', $role)
                                ->orderBy('tanggal_kirim', 'desc')
                                ->get();

        $dosenId = $userId;

        return view('notifikasidosen', compact('notifikasis', 'dosenId'));
    }
}
