<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengujiAdminController extends Controller
{
    public function index()
    {
        return view('pengujiadmin');
    }
}
