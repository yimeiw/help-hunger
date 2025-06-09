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
            'date_of_birth' => 'required|date',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
        ]);

        $user = auth()->user();
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->province_id = $request->province; 
        $user->city_id = $request->city;
        $user->save();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('dashboard.dashboard-admin');
            case 'volunteer':
                return redirect()->route('dashboard.dashboard-volunteer');
            case 'donatur':
                return redirect()->route('dashboard.dashboard-donatur');
            default:
                return redirect()->route('guest.welcome')->with('error', 'Invalid role');;
        }
    }

    public function getCities($provinceId)
    {
        $cities = Cities::where('province_id', $provinceId)->get(['id', 'cities_name']);
        return response()->json($cities);
    }
}
