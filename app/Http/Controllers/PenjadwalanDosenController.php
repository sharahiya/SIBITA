<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenjadwalanDosenController extends Controller
{
    public function index()
    {
        return view('penjadwalandosen');
    }
}
