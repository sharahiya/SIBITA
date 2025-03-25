<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestDosenController extends Controller
{
    public function index()
    {
        return view('requestdosen');
    }
}
