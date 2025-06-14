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
        'partner_email' => 'required|email',
        'password' => 'required',
    ]);

    $partner = \App\Models\Partner::where('partner_email', $credentials['partner_email'])->first();

    // if ($partner) {
    //     $passwordMatches = \Illuminate\Support\Facades\Hash::check($credentials['password'], $partner->password);

    //     // Output debugging sebelumnya
    //     dd(
    //         'Email from form:', $credentials['email'],
    //         'Password from form (plain):', $credentials['password'],
    //         'Hashed password from DB:', $partner->password,
    //         'Does password match hash?', $passwordMatches
    //     );
    //     // Hapus dd() di atas setelah Anda memastikan 'true'
    // }

    // --- Tambahkan ini: Debug hasil langsung dari Auth::attempt ---
    $attemptResult = Auth::guard('partner')->attempt($credentials, $request->remember);

    // dd('Result of Auth::guard("partner")->attempt():', $attemptResult); // <--- INI PENTING!

    if ($attemptResult) {
        $request->session()->regenerate();
        return redirect()->intended(route('partner.dashboard'));
    }

    throw ValidationException::withMessages([
        'email' => __('auth.failed'),
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