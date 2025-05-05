<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiAdminController extends Controller
{
    public function index()
    {
        return view('notifikasiadmin');
    }
}
