<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // tampilkan halaman login
    public function showLogin()
    {
        return view('pages.auth-login');
    }

    // proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/monitoring-kamera');
        }

        return back()->withErrors([
            'login_error' => 'Email atau password salah'
        ]);
    }

    // dashboard
    public function dashboard()
    {
        return "Login berhasil 🎉";
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect('/auth-login');
    }
}
