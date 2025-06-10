<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Provinces;
use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session; // Import Session

class RegisterAddressController extends Controller
{
    public function index()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }
        $provinces = Provinces::all();
        return view('auth.register-address', compact('provinces'));
    }

    public function registerAddress(Request $request)
    {
        $request->validate([
            'gender'        => 'required|string|max:10',
            'date_of_birth' => 'required|date',
            'province'      => 'required|string|max:100',
            'city'          => 'required|string|max:100',
        ]);

        $registrationData = Session::get('registration_data');

        $registrationData['gender'] = $request->gender;
        $registrationData['date_of_birth'] = $request->date_of_birth;
        $registrationData['province_id'] = $request->province;
        $registrationData['city_id'] = $request->city;

        
        $user = User::create([
            'name'          => $registrationData['name'],
            'username'      => $registrationData['username'],
            'phone'         => $registrationData['phone'],
            'email'         => $registrationData['email'],
            'password'      => $registrationData['password'],
            'role'          => $registrationData['role'],
            'gender'        => $registrationData['gender'],
            'date_of_birth' => $registrationData['date_of_birth'],
            'province_id'   => $registrationData['province_id'],
            'city_id'       => $registrationData['city_id'],
        ]);

        Session::forget('registration_data');

        event(new Registered($user));
        Auth::login($user);

        switch ($user->role) {
            case 'volunteer':
                return redirect()->route('volunteer.dashboard');
            case 'donatur':
                return redirect()->route('donatur.dashboard');
            default:
                return redirect()->route('guest.welcome')->with('error', 'Invalid role');
        }
    }

    public function getCities($provinceId)
    {
        $cities = Cities::where('province_id', $provinceId)->get(['id', 'cities_name']);
        return response()->json($cities);
    }
}