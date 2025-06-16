<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use App\Models\Partner;
use App\Models\LocationVolunteers;
use App\Models\LocationDonatur;

class GuestController extends Controller
{
    public function indexHome()
    {
        $eventsDonation = EventsDonatur::with(['partner', 'location', 'donations'])->take(2)->get();
        $eventsVolunteers = EventsVolunteers::with(['partner', 'location', 'volunteers'])->take(2)->get();
        $eventsPartner = Partner::take(9)->get();
        return view('guest-view.welcome', compact('eventsDonation', 'eventsVolunteers', 'eventsPartner'));
    }

    public function indexAbout()
    {
        return view('guest-view.about');
    }

    public function indexLocation()
    {
        return view('guest-view.locations.index');
    }

    public function searchLocation()
    {
        $zipcode = request()->input('zipcode');

        $locations = LocationVolunteers::with('events_volunteers.partner')
            ->where('zipcode', $zipcode)
            ->get();
        $locations2 = LocationDonatur::with('events_donatur.partner')
            ->where('zipcode', $zipcode)
            ->get();

        $locations = $locations->concat($locations2);

        if ($locations->isNotEmpty()) {
            return view('guest-view.locations.search', compact('locations'));
        } else {
            return redirect()->back()->with('error', 'No locations found.');
        }
    }


    public function indexEvents()
    {
        $events = EventsVolunteers::with(['partner', 'location', 'volunteers'])->get();
        return view('guest-view.events', compact('events'));
    }

    public function indexDonations()
    {
        $events = EventsDonatur::with(['partner', 'location', 'donations'])->get();
        return view('guest-view.donations', compact('events'));
    }

    public function indexPartner()
    {
        $partners = Partner::all();
        return view('guest-view.partner', compact('partners'));
    }
}
