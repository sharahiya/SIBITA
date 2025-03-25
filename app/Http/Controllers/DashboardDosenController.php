<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardDosenController extends Controller
{
    public function index()
    {
        return view('dashboarddosen');
    }
}
