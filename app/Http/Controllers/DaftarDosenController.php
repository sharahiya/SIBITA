<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarDosenController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'datamining'); // Default tab adalah 'datamining'
    return view('daftardosen', compact('tab'));
    }
}
