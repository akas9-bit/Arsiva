<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', ['tab' => 'siswa']);
    }

    public function login(Request $request)
    {
        $jenisLogin = $request->input('login_type');

        // LOGIN ADMIN
        if ($jenisLogin === 'admin') {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            $credentials['role'] = 'admin';

            if (Auth::attempt(
                $credentials,
                $request->boolean('remember')
            )) {
                $request->session()->regenerate();

                return redirect()->intended(
                    route('admin.dashboard')
                );
            }

            return back()
                ->withErrors([
                    'email' => 'Email atau password admin salah.',
                ])
                ->withInput($request->only('email'))
                ->with('tab', 'admin');
        }

        // LOGIN SISWA
        if ($jenisLogin === 'siswa') {
            $credentials = $request->validate([
                'nisn' => ['required', 'regex:/^[0-9]{8,10}$/'],
                'password' => ['required', 'string'],
            ], [
                'nisn.regex' => 'NISN harus terdiri dari 8 sampai 10 angka.',
            ]);

            $credentials['role'] = 'siswa';

            if (Auth::attempt(
                $credentials,
                $request->boolean('remember')
            )) {
                $request->session()->regenerate();

                return redirect()->intended(
                    route('beranda')
                );
            }

            return back()
                ->withErrors([
                    'nisn' => 'NISN atau password salah. Silakan hubungi admin jika lupa password.',
                ])
                ->withInput($request->only('nisn'))
                ->with('tab', 'siswa');
        }

        return back()->withErrors([
            'login_type' => 'Jenis login tidak valid.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
