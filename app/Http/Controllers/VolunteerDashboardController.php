<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use App\Models\Partner;


class VolunteerDashboardController extends Controller
{
    public function about(){
        return view('volunteer.about.show');
    }

    public function events()
    {
        $events = EventsVolunteers::with(['partner', 'location', 'volunteers'])->get();
        return view('volunteer.event.show', compact('events'));
    }

    public function eventsRegister(Request $request)
    {
        $events = EventsVolunteers::with(['partner', 'location'])->get();
        $selectedEvent = null;
        if ($request->has('event')) {
            $selectedEvent = EventsVolunteers::with(['location', 'partner'])->find($request->event);
        }

        return view('volunteer.event.create', compact('events', 'selectedEvent'));
    }

    public function partner()
    {
        $partners = Partner::all();
        return view('volunteer.partner.show', compact('partners'));
    }
}
