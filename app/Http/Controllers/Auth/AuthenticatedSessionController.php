<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        // Coba login sebagai staff (admin/counselor) dulu
        if (Auth::guard('staff')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $staff = Auth::guard('staff')->user();

            if ($staff->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('counselor.dashboard');
        }

        // Kalau bukan staff, coba login sebagai user biasa
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // Keduanya gagal
        return back()->withErrors([
            'email' => 'Email atau password yang kamu masukkan salah.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('staff')->check()) {
            Auth::guard('staff')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}