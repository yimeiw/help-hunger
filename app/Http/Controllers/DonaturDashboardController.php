<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use App\Models\Partner;

class DonaturDashboardController extends Controller
{
    public function donations()
    {
        $events = EventsDonatur::with(['partner', 'location', 'donations'])->get();
        return view('donatur.donations.show', compact('events'));
    }
}
