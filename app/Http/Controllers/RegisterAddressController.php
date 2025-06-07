<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinces;
use App\Models\Cities;

class RegisterAddressController extends Controller
{
    public function index()
    {
        $provinces = Provinces::all();
        return view('auth.register-address', compact('provinces'));
    }

    public function registerAddress(Request $request)
    {
        $request->validate([
            'gender' => 'required|string|max:10',
            'dob' => 'required|date',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
        ]);

        $user = auth()->user();
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->province_id = $request->province; 
        $user->city = $request->city;
        $user->save();

        return redirect()->route('dashboard');
    }

    public function getCities($provinceId)
    {
        $cities = Cities::where('province_id', $provinceId)->get(['id', 'name']);
        return response()->json($cities);
    }
}
