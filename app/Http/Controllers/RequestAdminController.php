<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestAdminController extends Controller
{
    public function index()
    {
        return view('requestadmin');
    }
}
