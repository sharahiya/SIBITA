<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileDosenController extends Controller
{
    public function index()
    {
        return view('profiledosen');
    }
}
