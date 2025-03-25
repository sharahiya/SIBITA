<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenAkunController extends Controller
{
    public function index()
    {
        return view('manajemenakun');
    }
}
