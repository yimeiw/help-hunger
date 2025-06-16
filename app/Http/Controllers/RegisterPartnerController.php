<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\PartnerAccounts;
use App\Models\Provinces; // Assuming you have a Provinces model
use App\Models\Cities;     // <--- You likely need a Cities model too
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterPartnerController extends Controller
{
    public function create(Request $request)
    {
        $provinces = Provinces::all();
        $partnerTypes = Partner::pluck('type')->unique();
        return view('auth.register-partner', compact('provinces', 'partnerTypes'));
    }

    public function store(Request $request)
    {
        // dd($request->all()); 
        $validatedData = $request->validate([
            'partner_name'  => 'required|string|max:255',
            'type'          => 'required|in:community,ngo,orphanage',
            'partner_email' => 'required|email|unique:partner,partner_email',
            'password'      => 'required|min:8|confirmed',
            'province'      => 'required|integer|exists:provinces,id', // Change 'string' to 'integer' and add 'exists'
            'city'          => 'required|integer|exists:cities,id', 
            'partner_link'  => 'required|string|max:255|url',
            'payment_methods' => 'required|array|min:1',
            'payment_methods.*.rekening_type' => 'required|in:BCA,Master Card,Link Aja',
            'payment_methods.*.no_rekening' => 'required|string|max:255',
        ]);

        // Buat entri Partner
        $partner = Partner::create([
            'partner_name'  => $validatedData['partner_name'],
            'type'          => $validatedData['type'],
            'partner_email' => $validatedData['partner_email'],
            'password'      => $validatedData['password'],
            'province_id'   => $validatedData['province'], // These will now be integers
            'city_id'       => $validatedData['city'],     // These will now be integers
            'partner_link'  => $validatedData['partner_link'],
        ]);

        // Simpan payment methods ke PartnerAccounts
        foreach ($request->payment_methods as $paymentMethod) {
            PartnerAccounts::create([
                'partner_id' => $partner->id,
                'rekening_type' => $paymentMethod['rekening_type'],
                'no_rekening' => $paymentMethod['no_rekening'],
            ]);
        }

        event(new Registered($partner));
        Auth::guard('partner')->login($partner);

        return redirect()->route('partner.dashboard');
    }
}