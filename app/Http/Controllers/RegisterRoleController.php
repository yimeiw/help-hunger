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
    public function index()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }

        $registrationData = Session::get('registration_data');
        $prefillMode = $registrationData['prefill_mode'] ?? false;
        $existingRole = $registrationData['existing_role'] ?? null;

        return view('auth.register-role', compact('prefillMode', 'existingRole', 'registrationData'));
    }

    public function registerRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:volunteer,donatur'
        ]);

        $registrationData = Session::get('registration_data');
        
        // Cek role apa saja yang sudah dipakai oleh email ini
        $existingRoles = User::where('email', $registrationData['email'])
                            ->pluck('role')
                            ->toArray();

        // Jika sudah punya role yang sama, tolak!
        if (in_array($request->role, $existingRoles)) {
            return back()->withErrors([
                'role' => 'You already registered as ' . ucfirst($request->role) . '. Choose another role or use another email.'
            ]);
        }
        
        $registrationData['role'] = $request->role;
        Session::put('registration_data', $registrationData);

        Session::save();
        // If in prefill mode, we can directly go to address confirmation/finalization
        // as other data (like address) is already in session.
        if (isset($registrationData['prefill_mode']) && $registrationData['prefill_mode'] === true) {
            // We'll proceed to the final step in RegisterAddressController to create the user
            return redirect()->route('register.address');
        }

        return redirect()->route('register.address');
    }
}