<?php

namespace App\Http\Controllers;
// Contoh, jika Anda membuat LoginPartnerController.php
// Pastikan route untuk login partner mengarah ke controller ini

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginPartnerController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-partner'); // View form login Partner
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // --- Gunakan guard 'partner' untuk mencoba login ---
        if (Auth::guard('partner')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('partner.dashboard')); // Redirect ke dashboard Partner
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'), // Pesan error login default Laravel
        ]);
    }

    public function logout(Request $request)
    {
        // --- Gunakan guard 'partner' untuk logout ---
        Auth::guard('partner')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect ke halaman utama atau halaman login Partner
    }
}