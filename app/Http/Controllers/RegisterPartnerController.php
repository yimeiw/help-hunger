<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
// use App\Models\User; // <-- Model User tidak relevan untuk login Partner sekarang
use App\Models\Partner; // Model Partner Anda yang Authenticatable
use App\Models\Provinces; // Jika digunakan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Tetap pakai Auth Facade
use Illuminate\Auth\Events\Registered;

class RegisterPartnerController extends Controller
{
    public function create(Request $request)
    {
        $provinces = Provinces::all();
        $partnerTypes = Partner::pluck('type')->unique(); // Ambil tipe partner unik
        return view('auth.register-partner', compact('provinces', 'partnerTypes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'partner_name'  => 'required|string|max:255',
            'type'          => 'required|in:community,ngo,orphanage',
            'partner_email' => 'required|email|unique:partner,partner_email', // Unik di tabel 'partner'
            'password'      => 'required|min:8|confirmed',
            'province'      => 'required|string|max:100',
            'city'          => 'required|string|max:100',
            'partner_link'  => 'required|string|max:255|url',
        ]);

        // Buat entri Partner
        $partner = Partner::create([
            'partner_name'  => $validatedData['partner_name'],
            'type'          => $validatedData['type'],
            'partner_email' => $validatedData['partner_email'],
            'password'      => $validatedData['password'], // Password akan di-hash otomatis oleh model karena '$casts'
            'province_id'   => $validatedData['province'], // Pastikan ini ID yang benar
            'city_id'       => $validatedData['city'],     // Pastikan ini ID yang benar
            'partner_link'  => $validatedData['partner_link'],
        ]);

        // Dispatch event Registered (akan memicu listener default Jetstream jika diatur)
        event(new Registered($partner));

        // --- Perubahan Penting di sini: Gunakan guard 'partner' untuk login ---
        Auth::guard('partner')->login($partner);

        // Redirect ke dashboard spesifik Partner atau halaman lainnya
        return redirect()->route('partner.dashboard'); // Sesuaikan dengan route dashboard Partner Anda
    }
}