<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterRoleController extends Controller
{
    public function index()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }
        return view('auth.register-role');
    }

    public function registerRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:volunteer,donatur'
        ]);

        $registrationData = Session::get('registration_data');
        
        // Cek role apa saja yang sudah dipakai oleh email ini
        $existingRoles = User::where('email', $registrationData['email'])
                            ->pluck('role')
                            ->toArray();

        // Jika sudah punya role yang sama, tolak!
        if (in_array($request->role, $existingRoles)) {
            return back()->withErrors([
                'role' => 'Anda sudah terdaftar sebagai ' . ucfirst($request->role) . '. Pilih peran lain atau gunakan email berbeda.'
            ]);
        }
        $registrationData['role'] = $request->role;
        Session::put('registration_data', $registrationData);

        return redirect()->route('register.address');
    }
}
