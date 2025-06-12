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
use App\Models\EventsDonationDetails;
use App\Models\EventsVolunteersDetail;
use Carbon\Carbon;

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
        $totalUsers = User::where('role', '!=', 'admin')->count();
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

    public function report(Request $request)
    {
        // --- Laporan Donasi per Bulan ---
        // Mendapatkan data donasi untuk 12 bulan terakhir
        $monthlyDonations = Donation::selectRaw('strftime("%Y-%m", created_at) as month, SUM(amount) as total_amount') // Untuk SQLite
                                    // ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total_amount') // Untuk MySQL
                                    ->where('created_at', '>=', Carbon::now()->subMonths(12))
                                    ->groupBy('month')
                                    ->orderBy('month')
                                    ->get();

        $donationMonths = $monthlyDonations->pluck('month')->toArray();
        $donationAmounts = $monthlyDonations->pluck('total_amount')->toArray();

        // --- Laporan Jumlah Pengguna per Role ---
        $userRoles = User::selectRaw('role, COUNT(*) as count')
                         ->groupBy('role')
                         ->get();

        $roleNames = $userRoles->pluck('role')->toArray();
        $roleCounts = $userRoles->pluck('count')->toArray();

        // --- Laporan Partisipasi Volunteer per Event (contoh sederhana) ---
        // Ini akan lebih baik jika ada relasi yang terdefinisi dengan baik antara Event dan EventsVolunteersDetail
        $topEventsByVolunteers = EventsVolunteers::select('event_name')
                                                 ->withCount('eventsVolunteersDetails') // Asumsi relasi hasMany eventVolunteersDetails di EventsVolunteers
                                                 ->orderByDesc('event_volunteers_details_count')
                                                 ->limit(5)
                                                 ->get();
        
        $eventNames = $topEventsByVolunteers->pluck('event_name')->toArray();
        $volunteerCounts = $topEventsByVolunteers->pluck('event_volunteers_details_count')->toArray();

        // Data yang akan dikirim ke view laporan
        $reportData = [
            'monthlyDonations' => [
                'labels' => $donationMonths,
                'data' => $donationAmounts
            ],
            'userRoles' => [
                'labels' => $roleNames,
                'data' => $roleCounts
            ],
            'topEventsByVolunteers' => [
                'labels' => $eventNames,
                'data' => $volunteerCounts
            ]
        ];

        return view('admin.report', compact('reportData')); // Membuat view baru untuk laporan
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
