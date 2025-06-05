<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterAddressController extends Controller
{
    public function index()
    {
        return view('auth.register-address');
    }

    public function registerAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'zipcode' => 'required|string|max:20',
        ]);

        $user = auth()->user();
        $user->address = $request->address;
        $user->city = $request->city;
        $user->zipcode = $request->zipcode;
        $user->save();

        return redirect()->route('dashboard');
    }
}
