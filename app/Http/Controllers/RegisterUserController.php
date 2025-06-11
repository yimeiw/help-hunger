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
     public function index() // <--- Metode ini ada
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
                'email' => 'This email already registered as Volunteer and Donatur. Please use another email.'
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

        // --- NEW LOGIC START ---
        // Check if the email exists with one account
        if ($existingUsers->count() == 1) {
            $existingUser = $existingUsers->first();
            Session::put('registration_data', [
                'name'              => $existingUser->name,
                'username'          => $existingUser->username,
                'phone'             => $existingUser->phone,
                'email'             => $existingUser->email,
                'password'          => $existingUser->password, // Storing hashed password
                'gender'            => $existingUser->gender,
                'date_of_birth'     => $existingUser->date_of_birth,
                'province_id'       => $existingUser->province_id,
                'city_id'           => $existingUser->city_id,
                'existing_role'     => $existingUser->role, // Store the existing role
                'prefill_mode'      => true, // Flag to indicate pre-filled data
            ]);
            return redirect()->route('register.role'); // Skip directly to role selection
        }
        // --- NEW LOGIC END ---


        // Simpan data di Session untuk tahap selanjutnya (pilih role) - ORIGINAL LOGIC
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
