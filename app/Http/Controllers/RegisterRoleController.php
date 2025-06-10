<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterRoleController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan ada data registrasi awal di session sebelum menampilkan form
        if (!$request->session()->has('registration_data')) {
            return redirect()->route('register');
        }
        return view('auth.register-role');
    }

    public function registerRole(Request $request)
    {
        // dd($request->all()); // <--- HAPUS ATAU KOMENTARI BARIS INI
        $validatedData = $request->validate([
            'role' => 'required|in:volunteer,donatur',
        ]);

        // Ambil data sebelumnya dari session dan tambahkan role
        $registrationData = $request->session()->get('registration_data');
        $registrationData['role'] = $validatedData['role'];
        $request->session()->put('registration_data', $registrationData);

        return redirect()->route('register.address'); // Seharusnya redirect ke register.address
    }
}