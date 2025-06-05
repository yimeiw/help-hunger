<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;


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
            'username' => 'required|string|max:255|unique:users,username',
            'phone'    => 'required|string|digits_between:10,15|unique:users,phone|regex:/^[0-9]+$/',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user)); // untuk verifikasi email, jika diaktifkan
        Auth::login($user);

        return redirect()->route('register.role');
    }
}
