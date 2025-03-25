<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaitingPageController extends Controller
{
    public function index()
    {
        return view('waitingpage');
    }
}
