<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterAddressController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('registration_data') || !isset($request->session()->get('registration_data')['role'])) {
            return redirect()->route('register');
        }
        $provinces = Provinces::all();

        $oldData = $request->session()->get('registration_data');

        return view('auth.register-address', compact('provinces', 'oldData'));
    }

    public function registerAddress(Request $request)
    {
        $validatedData = $request->validate([
            'gender' => 'required|string|max:10',
            'date_of_birth' => 'required|date',
            'province' => 'required|exists:provinces,id',
            'city' => 'required|exists:cities,id',
        ]);

        $registrationData = $request->session()->get('registration_data');

        $finalUserData = array_merge($registrationData, [
            'gender' => strtolower($validatedData['gender']),
            'date_of_birth' => $validatedData['date_of_birth'],
            'province_id' => $validatedData['province'],
            'city_id' => $validatedData['city'],
        ]);

        $user = User::create($finalUserData);

        event(new Registered($user));
        Auth::login($user);

        $request->session()->forget('registration_data');

        return redirect()->route('dashboard');
    }

    public function getCities($provinceId)
    {
        $cities = Cities::where('province_id', $provinceId)->get(['id', 'cities_name as name']);
        return response()->json($cities);
    }
}
