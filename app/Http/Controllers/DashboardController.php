<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donatur;
use App\Models\Donation;
use App\Models\Volunteer;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use App\Models\Partner;
use Illuminate\Support\Facades\Auth; 

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
        // 1. Total Donasi Terkumpul (jika ada kolom amount di tabel donations)
        // Asumsi ada kolom 'amount' di tabel 'donations' atau 'events_donation_details'
        // Jika donasi dihitung per event, Anda mungkin perlu menyesuaikannya
        $totalDonationAmount = Donation::sum('amount'); // Sesuaikan 'amount' dengan kolom yang menyimpan jumlah donasi
        // Atau jika dari events_donation_details:
        // $totalDonationAmount = EventsDonationDetails::sum('donation_target');


        // 2. Jumlah Pengguna
        $totalUsers = User::count();
        $totalVolunteers = User::where('role', 'volunteer')->count();
        $totalDonaturs = User::where('role', 'donatur')->count();
        $totalAdmins = User::where('role', 'admin')->count(); // Jika ada peran admin di tabel users

        // 3. Jumlah Event
        $totalEvents = EventsVolunteers::count(); // Atau EventsDonatur::count() jika terpisah
        $upcomingEvents = EventsVolunteers::where('start_date', '>', now())->count(); // Sesuaikan nama kolom tanggal
        $activeEvents = EventsVolunteers::where('start_date', '<=', now())
                                        ->where('end_date', '>=', now())
                                        ->count(); // Sesuaikan nama kolom tanggal
        $completedEvents = EventsVolunteers::where('end_date', '<', now())->count(); // Sesuaikan nama kolom tanggal

        // 4. Jumlah Partner
        $totalPartners = Partner::count();

        // Data yang akan dikirim ke view
        $statistics = [
            'totalDonationAmount' => $totalDonationAmount,
            'totalUsers' => $totalUsers,
            'totalVolunteers' => $totalVolunteers,
            'totalDonaturs' => $totalDonaturs,
            'totalAdmins' => $totalAdmins,
            'totalEvents' => $totalEvents,
            'upcomingEvents' => $upcomingEvents,
            'activeEvents' => $activeEvents,
            'completedEvents' => $completedEvents,
            'totalPartners' => $totalPartners,
        ];

        return view('admin.dashboard', compact('statistics'));
    }

    public function location(){
        return view('admin.location');
    }

    public function report() {
        return view('admin.report');
    }

    public function manage() {
        return view('admin.manage');
    }

    public function manageUser() {
        return view('admin.manage.manage-user');
    }

    public function manageEvent() {
        return view('admin.manage.manage-event');
    }

    public function volunteer()
    {
        $loggedInUserEmail = Auth::user()->email;
        $donaturUser = User::where('email', $loggedInUserEmail)
                             ->where('role', 'donatur')
                             ->first();

        $eventsDonation = EventsDonatur::with(['partner', 'location', 'donations'])->take(2)->get();
        $eventsVolunteers = EventsVolunteers::with(['partner', 'location', 'volunteers'])->take(2)->get();
        $eventsPartner = Partner::all();
        return view('volunteer.dashboard', compact('eventsDonation', 'eventsVolunteers', 'eventsPartner', 'donaturUser'));
    }

    public function donatur()
    {
        $eventsDonation = EventsDonatur::with(['partner', 'location', 'donations'])->take(2)->get();
        $eventsVolunteers = EventsVolunteers::with(['partner', 'location', 'volunteers'])->take(2)->get();
        $eventsPartner = Partner::all();
        return view('donatur.dashboard', compact('eventsDonation', 'eventsVolunteers', 'eventsPartner')); 
    }

}
