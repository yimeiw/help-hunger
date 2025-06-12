<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donation;
use App\Models\Partner;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    // ===== USER =====
    public function manageVolunteer()
    {
        $volunteers = User::where('role', 'volunteer')->get();
        return view('admin.manage.user.volunteer', compact('volunteers'));
    }

    public function manageDonatur()
    {
        $donaturs = User::where('role', 'donatur')->get();
        return view('admin.manage.user.donatur', compact('donaturs'));
    }

    public function managePartner()
    {
        $partners = User::where('role', 'partner')->get();
        return view('admin.manage.user.partner', compact('partners'));
    }

    public function deleteVolunteer($id)
    {
        User::where('id', $id)->where('role', 'volunteer')->delete();
        return back()->with('success', 'Volunteer deleted.');
    }

    public function deleteDonatur($id)
    {
        User::where('id', $id)->where('role', 'donatur')->delete();
        return back()->with('success', 'Donatur deleted.');
    }

    public function deletePartner($id)
    {
        User::where('id', $id)->where('role', 'partner')->delete();
        return back()->with('success', 'Partner deleted.');
    }

    // ===== EVENT =====
    public function manageEventVolunteer()
    {
        $events = EventsVolunteers::all();
        return view('admin.manage.event.volunteer', compact('events'));
    }

    public function storeEventVolunteer(Request $request)
    {
        EventsVolunteers::create($request->all());
        return back()->with('success', 'Volunteer event created.');
    }

    public function deleteEventVolunteer($id)
    {
        EventsVolunteers::destroy($id);
        return back()->with('success', 'Volunteer event deleted.');
    }

    public function manageEventDonation()
    {
        $events = EventsDonatur::all();
        return view('admin.manage.event.donation', compact('events'));
    }

    public function storeEventDonation(Request $request)
    {
        EventsDonatur::create($request->all());
        return back()->with('success', 'Donation event created.');
    }

    public function deleteEventDonation($id)
    {
        EventsDonatur::destroy($id);
        return back()->with('success', 'Donation event deleted.');
    }
}
