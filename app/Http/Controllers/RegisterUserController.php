<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterUserController extends Controller
{
     public function index() // <--- Metode ini ada
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name'     => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'phone'    => 'required|string|digits_between:10,15|unique:users,phone|regex:/^[0-9]+$/',
                'email'    => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
                'password' => 'required|min:8|confirmed',
            ]);

            // Ini akan dijalankan HANYA jika validasi berhasil
            // dd($validatedData, $request->session()->all()); // Hapus atau komen baris ini setelah debugging

            $validatedData['password'] = Hash::make($validatedData['password']);
            $request->session()->put('registration_data', $validatedData);

            return redirect()->route('register.role');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, ini akan menangkap pengecualian
            // dd($e->errors()); // Hapus atau komen baris ini setelah debugging
            throw $e; // Lempar kembali exception agar redirect back with errors tetap terjadi
        }
    }
}