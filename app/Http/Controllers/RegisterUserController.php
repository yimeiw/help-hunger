<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;


class RegisterUserController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'phone'    => 'required|string|digits_between:10,15|regex:/^08[0-9]+$/',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Cek apakah email sudah punya 2 akun (volunteer + donatur)
        $existingUsers = User::where('email', $request->email)->get();
        
        if ($existingUsers->count() >= 2) {
            return back()->withErrors([
                'email' => 'Email ini sudah terdaftar sebagai Volunteer dan Donatur. Tidak bisa mendaftar lagi.'
            ]);
        }

        // Validasi unik untuk username berdasarkan email
        $usernameConflict = User::where('username', $request->username)
            ->where('email', '!=', $request->email)
            ->exists();

        if ($usernameConflict) {
            return back()->withErrors([
                'username' => 'Username ini sudah digunakan oleh pengguna lain.'
            ]);
        }

        // Simpan data di Session untuk tahap selanjutnya (pilih role)
        Session::put('registration_data', [
            'name'     => $request->name,
            'username' => $request->username,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register.role');
    }

}
