<?php

namespace App\Http\Controllers;

use App\Models\Partner; 
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donatur;
use App\Models\Donation;
use App\Models\Volunteer;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use Illuminate\Support\Facades\Auth; 
use App\Models\EventsDonationDetails;
use App\Models\EventsVolunteersDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\LocationVolunteers;
use App\Models\LocationDonatur;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    public function index()
    {
        // Mendapatkan data partner yang sedang login melalui guard 'partner'
        $loggedInPartner = Auth::guard('partner')->user();

        // Mengambil data Events Donatur
        // (Anda bisa menyesuaikan jumlah take() atau menambahkan filter lain)
        $eventsDonation = EventsDonatur::with(['partner', 'location', 'donations'])->take(2)->get();

        // Mengambil data Events Volunteers
        // (Anda bisa menyesuaikan jumlah take() atau menambahkan filter lain)
        $eventsVolunteers = EventsVolunteers::with(['partner', 'location', 'volunteers'])->take(2)->get();
        
        // Mengambil semua partner (jika Anda ingin menampilkannya di dashboard partner)
        $eventsPartner = Partner::all(); // Ini mungkin bisa di-refactor jika hanya untuk melihat daftar partner lain

        // Mengembalikan view dashboard partner dengan semua data yang dibutuhkan
        return view('partner.dashboard', compact(
            'loggedInPartner',
            'eventsDonation',
            'eventsVolunteers',
            'eventsPartner'
        ));
    }

    public function about()
    {
        return view('partner.about.show');
    }

    public function locations()
    {
        return view('partner.locations.show');
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
            return view('partner.locations.search', compact('locations'));
        } else {
            return redirect()->back()->with('error', 'No locations found.');
        }
    }

    public function program()
    {
        return view('partner.program.show');
    }

    public function report(Request $request)
    {
        if (!Auth::guard('partner')->check()) {
            return redirect('/login/partner')->with('error', 'Anda harus login sebagai Partner untuk mengakses laporan ini.');
        }

        $loggedInPartner = Auth::guard('partner')->user();
        $partnerId = $loggedInPartner->id;

        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfMonth();

        // --- Laporan Donasi per Bulan ---
        $monthlyDonations = collect();
        $currentMonth = $startDate->copy()->startOfMonth();

        while ($currentMonth->lte($endDate->copy()->startOfMonth())) {
            $label = $currentMonth->format('M Y');

            $total = Donation::where('partner_id', $partnerId)
                // Pastikan filter ini menggunakan tabel 'donation' jika 'created_at' ada di sana.
                // Jika 'created_at' adalah dari relasi EventsDonatur, biarkan saja.
                // Karena model Donation sudah pakai 'donation', maka ini akan otomatis benar.
                ->whereBetween('created_at', [$currentMonth->copy()->startOfMonth(), $currentMonth->copy()->endOfMonth()])
                ->sum('amount');

            $monthlyDonations->push([
                'label' => $label,
                'total' => $total,
            ]);
            $currentMonth->addMonth();
        }

        // --- Laporan Jumlah Pengguna per Role ---
        $userRoles = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->get();
        $roleNames = $userRoles->pluck('role')->toArray();
        $roleCounts = $userRoles->pluck('count')->toArray();

        $communityCount = Partner::where('type', 'community')->count();
        $ngoCount = Partner::where('type', 'ngo')->count();
        $orphanageCount = Partner::where('type', 'orphanage')->count();

        // --- Laporan Partisipasi Volunteer per Event ---
        $topEventsByVolunteers = EventsVolunteers::where('partner_id', $partnerId)
            ->whereHas('volunteers', function ($query) use ($startDate, $endDate) {
                // KOREKSI: Gunakan nama pivot table yang benar
                $query->whereBetween('events_volunteers_detail.created_at', [$startDate, $endDate]);
            })
            ->select('event_name')
            ->withCount(['volunteers' => function ($query) use ($startDate, $endDate) {
                // KOREKSI: Gunakan nama pivot table yang benar
                $query->whereBetween('events_volunteers_detail.created_at', [$startDate, $endDate]);
            }])
            ->orderByDesc('volunteers_count')
            ->limit(5)
            ->get();

        $eventNames = $topEventsByVolunteers->pluck('event_name')->toArray();
        $volunteerCounts = $topEventsByVolunteers->pluck('volunteers_count')->toArray();

        // --- Laporan Baru: Jumlah Event Diselenggarakan per Bulan oleh Partner ---
        $monthlyEvents = collect();
        $currentMonth = $startDate->copy()->startOfMonth();

        while ($currentMonth->lte($endDate->copy()->startOfMonth())) {
            $label = $currentMonth->format('M Y');

            $totalVolunteerEvents = EventsVolunteers::where('partner_id', $partnerId)
                ->whereBetween('created_at', [$currentMonth->copy()->startOfMonth(), $currentMonth->copy()->endOfMonth()])
                ->count();

            $totalDonaturEvents = EventsDonatur::where('partner_id', $partnerId)
                ->whereBetween('created_at', [$currentMonth->copy()->startOfMonth(), $currentMonth->copy()->endOfMonth()])
                ->count();

            $monthlyEvents->push([
                'label' => $label,
                'volunteer_events' => $totalVolunteerEvents,
                'donatur_events' => $totalDonaturEvents,
            ]);
            $currentMonth->addMonth();
        }

        // --- Laporan Partner yang Login dan Partisipasi ---
        $partnerReports = [
            'partner_name' => $loggedInPartner->partner_name,
            'total_volunteer_events' => $loggedInPartner->eventsVolunteers()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'total_donatur_events' => $loggedInPartner->eventsDonatur()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'volunteer_event_details' => $loggedInPartner->eventsVolunteers()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->withCount(['volunteers' => function ($query) use ($startDate, $endDate) {
                    // KOREKSI: Gunakan nama pivot table yang benar
                    $query->whereBetween('events_volunteers_detail.created_at', [$startDate, $endDate]);
                }])
                ->get()
                ->map(function ($event) {
                    return [
                        'event_name' => $event->event_name,
                        'total_volunteers' => $event->volunteers_count,
                    ];
                }),

            'donatur_event_details' => $loggedInPartner->eventsDonatur()
                ->whereBetween('created_at', [$startDate, $endDate]) // Filter event creation date
                ->withSum(['donations' => function ($query) use ($startDate, $endDate) {
                    // KOREKSI: Gunakan nama tabel 'donation' (singular) sesuai model Donation Anda
                    $query->whereBetween('donation.created_at', [$startDate, $endDate]); // Filter donation date
                }], 'amount')
                ->get()
                ->map(function ($event) {
                    return [
                        'event_name' => $event->event_name,
                        'total_donations_collected' => $event->donations_sum_amount ?? 0,
                    ];
                }),
        ];


        $reportData = [
            'monthlyDonations' => [
                'labels' => $monthlyDonations->pluck('label'),
                'data' => $monthlyDonations->pluck('total'),
            ],
            'userRoles' => [
                'labels' => array_merge($roleNames, ['Community', 'NGO', 'Orphanage']),
                'data' => array_merge($roleCounts, [$communityCount, $ngoCount, $orphanageCount])
            ],
            'topEventsByVolunteers' => [
                'labels' => $eventNames,
                'data' => $volunteerCounts
            ],
            'monthlyEvents' => [
                'labels' => $monthlyEvents->pluck('label'),
                'volunteer_data' => $monthlyEvents->pluck('volunteer_events'),
                'donatur_data' => $monthlyEvents->pluck('donatur_events'),
            ],
            'partnerReports' => $partnerReports,
            'loggedInPartner' => $loggedInPartner,
        ];

        // Di dalam metode controller Anda, setelah filter diterapkan
        $startDate = request('start_date', Carbon::now()->subMonths(11)->startOfMonth());
        $endDate = request('end_date', Carbon::now()->endOfMonth());

        // ... kode untuk monthlyDonations, monthlyEvents, topEventsByVolunteers ...

        // Contoh data untuk distribusi status event relawan
        $totalVolunteerEvents = EventsVolunteers::whereBetween('start_date', [$startDate, $endDate])
                                    ->where('partner_id', auth()->user()->partner_id) // Jika ini laporan per partner
                                    ->count();
        $completedVolunteerEvents = EventsVolunteers::whereBetween('start_date', [$startDate, $endDate])
                                        ->where('partner_id', auth()->user()->partner_id)
                                        ->where('status', 'completed') // Atau kondisi status Anda
                                        ->count();
        $ongoingVolunteerEvents = EventsVolunteers::whereBetween('start_date', [$startDate, $endDate])
                                    ->where('partner_id', auth()->user()->partner_id)
                                    ->where('status', 'ongoing') // Atau kondisi status Anda
                                    ->count();
        $upcomingVolunteerEvents = EventsVolunteers::whereBetween('start_date', [$startDate, $endDate])
                                        ->where('partner_id', auth()->user()->partner_id)
                                        ->where('status', 'upcoming') // Atau kondisi status Anda
                                        ->count();

        $reportData['volunteerEventStatus'] = [
            'labels' => ['Selesai', 'Sedang Berlangsung', 'Akan Datang'],
            'data' => [$completedVolunteerEvents, $ongoingVolunteerEvents, $upcomingVolunteerEvents]
        ];

        // Contoh data untuk distribusi status event donasi
        $totalDonaturEvents = EventsDonatur::whereBetween('start_date', [$startDate, $endDate])
                                    ->where('partner_id', auth()->user()->partner_id)
                                    ->count();
        $completedDonaturEvents = EventsDonatur::whereBetween('start_date', [$startDate, $endDate])
                                    ->where('partner_id', auth()->user()->partner_id)
                                    ->where('status', 'completed')
                                    ->count();
        $activeDonaturEvents = EventsDonatur::whereBetween('start_date', [$startDate, $endDate])
                                    ->where('partner_id', auth()->user()->partner_id)
                                    ->where('status', 'active') // Atau kondisi status Anda
                                    ->count();

        $reportData['donaturEventStatus'] = [
            'labels' => ['Selesai', 'Aktif/Berlangsung'],
            'data' => [$completedDonaturEvents, $activeDonaturEvents]
        ];

        return view('partner.report.show', compact('reportData'));
    }




    public function notifications()
    {
        return view('partner.notifications.show');
    }

    public function profile()
    {
        return view('partner.profile.show');
    }

}
