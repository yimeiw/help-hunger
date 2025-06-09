<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard.dashboard-admin');
        } elseif ($user->isVolunteer()) {
            return redirect()->route('dashboard.dashboard-volunteer');
        } elseif ($user->isDonatur()) {
            return redirect()->route('dashboard.dashboard-donatur');
        } else {
            return redirect()->route('guest.welcome');
        }
    }

    public function admin()
    {
        return view('dashboard.dashboard-admin');
    }

    public function volunteer()
    {
        return view('dashboard.dashboard-volunteer');
    }

    public function donatur()
    {
        return view('dashboard.dashboard-donatur');
    }

}
