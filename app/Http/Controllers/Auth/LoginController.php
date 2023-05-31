<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 1
        ])) {
            return redirect()->route('dashboard')->with('sukses', 'Selamat Datang!');
        } elseif (Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 2
        ])) {
            return redirect()->route('agen.dashboard')->with('sukses', 'Selamat Datang!');
        }

        return redirect('login')->with('gagal', 'Username atau Password anda salah!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('gagal', 'Sign Out Berhasil!');
    }
}
