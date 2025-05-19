<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showloginpage()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('npm', 'password');

        // Cek login berdasarkan role
        if ($request->role === 'mahasiswa') {
            if (Auth::guard('mahasiswa')->attempt(['npm' => $request->npm, 'password' => $request->password])) {
                return redirect()->intended('/dashboard');
            }
        } elseif ($request->role === 'dosen') {
            if (Auth::guard('dosen')->attempt(['nip' => $request->npm, 'password' => $request->password])) {
                return redirect()->intended('/dashboarddosen');
            }
        } elseif ($request->role === 'admin') {
            if (Auth::guard('admin')->attempt(['username' => $request->npm, 'password' => $request->password])) {
                return redirect()->intended('/dashboardadmin');
            }
        }

        // Jika gagal login, redirect balik dengan pesan error
        return redirect()->back()->withInput()->withErrors([
            'login' => 'Login gagal. Pastikan data yang Anda masukkan benar.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
