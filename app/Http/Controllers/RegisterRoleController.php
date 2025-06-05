<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterRoleController extends Controller
{
    public function index()
    {
        return view('auth.register-role');
    }

    public function registerRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:volunteer,donatur',
        ]);

        $user = auth()->user(); 
        $user->role = $request->role; 
        $user->save();

        return redirect()->route('register.address');
    }
}
