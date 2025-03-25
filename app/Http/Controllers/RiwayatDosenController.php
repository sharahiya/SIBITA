<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatDosenController extends Controller
{
    public function index()
    {
        return view('riwayatdosen');
    }
}
