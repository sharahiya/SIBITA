<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetPassController extends Controller
{
    public function index()
    {
        return view('resetpass');
    }
}
