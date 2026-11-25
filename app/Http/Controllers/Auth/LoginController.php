<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses permintaan login dan mengarahkan user sesuai role.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Arahkan Admin / Pemilik Toko ke Dashboard Admin
            if (in_array($user->role, ['admin', 'pemilik'], true)) {
                return redirect()->route('admin.dashboard');
            }

            // Arahkan Vendor ke Dashboard Vendor (jika route tersedia)
            if ($user->role === 'vendor') {
                return Route::has('vendor.dashboard')
                    ? redirect()->route('vendor.dashboard')
                    : redirect('/vendor/dashboard');
            }

            // Default redirect untuk role lainnya (misalnya karyawan)
            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
            ])
            ->onlyInput('email');
    }

    /**
     * Keluar dari sesi login (logout).
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}