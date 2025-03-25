<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenAkunAdminController extends Controller
{
    public function index()
    {
        return view('manajemenakunadmin');
    }
}
