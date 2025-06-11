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
    public function index(Request $request)
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

        return redirect()->route('register.address'); // Seharusnya redirect ke register.address
    }
}