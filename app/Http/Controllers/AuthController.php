<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // tampilkan halaman login
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/monitoring-kamera');
        }

        return view('pages.auth-login');
    }

    // proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/monitoring-kamera');
        }

        return back()
            ->withErrors([
                'login_error' => 'Username atau password salah'
            ])
            ->withInput($request->only('username'));
    }

    // dashboard
    public function dashboard()
    {
        return redirect('/monitoring-kamera');
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth-login');
    }
}