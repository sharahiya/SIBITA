<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiDosenController extends Controller
{
    public function index()
    {
        return view('notifikasidosen');
    }
}
