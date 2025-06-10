<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donatur;
use App\Models\Volunteer;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use App\Models\Partner;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isVolunteer()) {
            return redirect()->route('volunteer.dashboard');
        } elseif ($user->isDonatur()) {
            return redirect()->route('donatur.dashboard');
        } else {
            return redirect()->route('guest.welcome');
        }
    }

    public function admin()
    {
        return view('admin.dashboard');
    }

    public function volunteer()
    {
        $eventsDonation = EventsDonatur::with(['partner', 'location', 'donations'])->take(2)->get();
        $eventsVolunteers = EventsVolunteers::with(['partner', 'location', 'volunteers'])->take(2)->get();
        $eventsPartner = Partner::all();
        return view('volunteer.dashboard', compact('eventsDonation', 'eventsVolunteers', 'eventsPartner'));
    }

    public function donatur()
    {
        $eventsDonation = EventsDonatur::with(['partner', 'location', 'donations'])->take(2)->get();
        $eventsVolunteers = EventsVolunteers::with(['partner', 'location', 'volunteers'])->take(2)->get();
        $eventsPartner = Partner::all();
        return view('donatur.dashboard', compact('eventsDonation', 'eventsVolunteers', 'eventsPartner')); 
    }

}
