<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Partner; 
use Illuminate\Http\Request;
use App\Models\Donatur;
use App\Models\Donation;
use App\Models\Volunteer;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use Illuminate\Support\Facades\Auth; 
use App\Models\EventsDonationDetails;
use App\Models\EventsVolunteersDetail;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\LocationVolunteers;
use App\Models\LocationDonatur;
use App\Models\Provinces; 
use App\Models\Cities;     
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

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

    public function program(Request $request)
    {
        $eventType = $request->query('type', 'volunteer');
        $events = collect();
        $partnerId = Auth::guard('partner')->id();

        if ($eventType === 'volunteer') {
            $events = EventsVolunteers::with(['partner', 'location'])
                                      ->where('partner_id', $partnerId)
                                      ->paginate(10);
        } elseif ($eventType === 'donation') {
            $events = EventsDonatur::with(['partner', 'location'])
                                   ->where('partner_id', $partnerId)
                                   ->paginate(10);
        }

        return view('partner.program.show', compact('eventType', 'events'));
    }

    public function createVolunteerEvent()
    {
        $partners = Partner::all();
        $provinces = Provinces::all(); // Get all provinces
        // No need to fetch cities initially, they will be loaded via AJAX

        return view('partner.program.create-volunteer', compact('partners', 'provinces'));
    }


    public function storeVolunteerEvent(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_volunteers' => 'required|integer|min:1',
            'current_needs' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // New fields for creating a location
            'location_name' => 'required|string|max:255',
            'location_address' => 'required|string|max:255',
            'location_zipcode' => 'required|digits:5', // Assuming 5-digit zipcode
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        // 1. Create the new LocationVolunteers entry
        $location = LocationVolunteers::create([
            'name' => $validatedData['location_name'],
            'address' => $validatedData['location_address'],
            'zipcode' => $validatedData['location_zipcode'],
            'province_id' => $validatedData['province_id'],
            'city_id' => $validatedData['city_id'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        // 2. Prepare event data
        $eventData = [
            'event_name' => $validatedData['event_name'],
            'event_description' => $validatedData['event_description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'max_volunteers' => $validatedData['max_volunteers'],
            'current_needs' => $validatedData['current_needs'],
            'partner_id' => Auth::guard('partner')->id(),
            'status' => 'pending', // Or 'pending' if you need approval
            'location_id' => $location->id, // Assign the newly created location's ID
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images/volunteer', 'public');
            $eventData['image_path'] = $imagePath;
        }

        // 3. Create the event
        EventsVolunteers::create($eventData);

        // Create notification for admin about new volunteer event
        $adminUsers = User::where('role', 'admin')->get(); // Asumsi ada kolom 'role' di tabel users
        
        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'partner_id' => null,
                'title' => 'New Volunteer Event Created',
                'message' => 'Partner ' . Auth::guard('partner')->user()->partner_name . ' has created a new volunteer event: ' . $eventData['event_name'] . '. Please review for approval.',
                'is_read' => false,
            ]);
        }

        // Juga bisa menambahkan notifikasi untuk partner itu sendiri
        $notificationData = [
            'user_id' => null, 
            'partner_id' => Auth::guard('partner')->id(), // <-- Use partner_id here!
            'title' => 'Volunteer Event Successfully Created',
            'message' => 'Your Volunteer Event  "' . $eventData['event_name'] . '" successfully created and waiting for admin approval.',
            'is_read' => false,
        ];

        // dd($notificationData); // Tambahkan dd() di sini untuk melihat isinya
        Notification::create($notificationData); 


        return redirect()->route('partner.program.show', ['type' => 'volunteer'])->with('success', 'Volunteer event added successfully!');
    }


    public function createDonationEvent()
    {
        $locations = LocationDonatur::all();
        $provinces = Provinces::all(); // Get all provinces
        // No need to fetch cities initially, they will be loaded via AJAX

        return view('partner.program.create-donation', compact('locations', 'provinces'));
    }

    public function storeDonationEvent(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'donation_target' => 'required|numeric|min:1000',
            // disini harus ada payment type dan no rekening
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // New fields for creating a location for donation events
            'location_name' => 'required|string|max:255',
            'location_address' => 'required|string|max:255',
            'location_zipcode' => 'required|digits:5', // Assuming 5-digit zipcode
            'province_id' => 'required|exists:provinces,id', // Validasi terhadap tabel provinces
            'city_id' => 'required|exists:cities,id',       // Validasi terhadap tabel cities
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        // 1. Create the new LocationDonaturs entry
        // Pastikan model LocationDonaturs memiliki $fillable yang sesuai
        $location = LocationDonatur::create([
            'name' => $validatedData['location_name'],
            'address' => $validatedData['location_address'],
            'zipcode' => $validatedData['location_zipcode'],
            'province_id' => $validatedData['province_id'],
            'city_id' => $validatedData['city_id'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        // 2. Prepare event data
        $eventData = [
            'event_name' => $validatedData['event_name'],
            'event_description' => $validatedData['event_description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'donation_target' => $validatedData['donation_target'],
            'partner_id' => Auth::guard('partner')->id(),
            'status' => 'pending', // Or your default status
            'location_id' => $location->id, // Assign the newly created location's ID
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images/donation', 'public');
            $eventData['image_path'] = $imagePath;
        }

        // 3. Create the event
        // Pastikan model EventsDonatur memiliki $fillable yang sesuai
        EventsDonatur::create($eventData);

        // Create notification for admin about new volunteer event
        $adminUsers = User::where('role', 'admin')->get(); // Asumsi ada kolom 'role' di tabel users
        
        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'partner_id' => null,
                'title' => 'New Donation Event Created',
                'message' => 'Partner ' . Auth::guard('partner')->user()->partner_name . ' has created a new donation event: ' . $eventData['event_name'] . '. Please review for approval.',
                'is_read' => false,
            ]);
        }

        // Juga bisa menambahkan notifikasi untuk partner itu sendiri
        Notification::create([
            'partner_id' => Auth::guard('partner')->id(), // <-- Use partner_id here!
            'user_id' => null, 
            'title' => 'Donation Event Successfully Created',
            'message' => 'Your Donation Event  "' . $eventData['event_name'] . '" successfully created and waiting for admin approval.',
            'is_read' => false,
        ]);

        return redirect()->route('partner.program.show', ['type' => 'donation'])->with('success', 'Donation event added successfully!');
    }


    public function getCitiesByProvince($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->pluck('name', 'id');
        return response()->json($cities);
    }


    public function showVolunteerEvent(EventsVolunteers $event) // Using route model binding
    {
        // Ensure the event belongs to the authenticated partner
        if ($event->partner_id !== Auth::guard('partner')->id()) {
            abort(403); // Forbidden
        }
        return view('partner.program.show-volunteer-detail', compact('event'));
    }


    public function showDonationEvent(EventsDonatur $event) // Using route model binding
    {
        // Ensure the event belongs to the authenticated partner
        if ($event->partner_id !== Auth::guard('partner')->id()) {
            abort(403); // Forbidden
        }
        return view('partner.program.show-donation-detail', compact('event'));
    }


    public function deleteVolunteerEvent(EventsVolunteers $event)
    {
        if ($event->partner_id !== Auth::guard('partner')->id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this event.');
        }
        // Optionally delete image from storage
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }
        $event->delete();
        return redirect()->route('partner.program.show', ['type' => 'volunteer'])->with('success', 'Volunteer event deleted successfully!');
    }

    // Example for deleting donation event
    public function deleteDonationEvent(EventsDonatur $event)
    {
        if ($event->partner_id !== Auth::guard('partner')->id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this event.');
        }
        // Optionally delete image from storage
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }
        $event->delete();
        return redirect()->route('partner.program.show', ['type' => 'donation'])->with('success', 'Donation event deleted successfully!');
    }



    public function report(Request $request)
    {
        if (!Auth::guard('partner')->check()) {
            return redirect('/login/partner')->with('error', 'Anda harus login sebagai Partner untuk mengakses laporan ini.');
        }

        $eventType = $request->query('type', 'volunteer');
        $events = collect();
        $partnerId = Auth::guard('partner')->id();

        if ($eventType === 'volunteer') {
            $events = EventsVolunteers::with(['partner', 'location'])
                                      ->where('partner_id', $partnerId)
                                      ->paginate(10);
        } elseif ($eventType === 'donation') {
            $events = EventsDonatur::with(['partner', 'location'])
                                   ->where('partner_id', $partnerId)
                                   ->paginate(10);
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

            $total = Donation::join('events_donatur', 'donation.event_id', '=', 'events_donatur.id')
                ->where('events_donatur.partner_id', $partnerId)
                ->whereBetween('donation.created_at', [
                    $currentMonth->copy()->startOfMonth(),
                    $currentMonth->copy()->endOfMonth()
                ])
                ->sum('donation.amount');

            $monthlyDonations->push([
                'label' => $label,
                'total' => $total,
            ]);
            $currentMonth->addMonth();
        }

    
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
                        'status' => $event->status
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
                        'status' => $event->status
                    ];
                }),
        ];


        $reportData = [
            'monthlyDonations' => [
                'labels' => $monthlyDonations->pluck('label')->toArray(), // Convert to array
                'data' => $monthlyDonations->pluck('total')->toArray(),   // Convert to array
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
        $statusOrder = ['accepted', 'pending', 'rejected'];

        // ... kode untuk monthlyDonations, monthlyEvents, topEventsByVolunteers ...

        // Contoh data untuk distribusi status event relawan
        $totalVolunteerEvents = EventsVolunteers::whereBetween('start_date', [$startDate, $endDate])
                                    ->where('partner_id', auth()->user()->partner_id) // Jika ini laporan per partner
                                    ->count();
        $statusCounts = EventsVolunteers::where('partner_id', auth('partner')->id())
                                ->selectRaw('status, count(*) as count')
                                ->groupBy('status')
                                ->pluck('count', 'status')
                                ->toArray();

        $reportData['volunteerEventStatus'] = [
                'labels' => $statusOrder,
                'data' => array_map(function($status) use ($statusCounts) {
                    return $statusCounts[$status] ?? 0;
                }, $statusOrder),
                'hasData' => array_sum($statusCounts) > 0
        ];

        // Contoh data untuk distribusi status event donasi
        $totalDonaturEvents = EventsDonatur::whereBetween('start_date', [$startDate, $endDate])
                                    ->where('partner_id', auth()->user()->partner_id)
                                    ->count();
        $statusCounts = EventsDonatur::where('partner_id', auth('partner')->id())
                            ->selectRaw('status, count(*) as count')
                            ->groupBy('status')
                            ->pluck('count', 'status')
                            ->toArray();


        $reportData['donaturEventStatus'] = [
                'labels' => $statusOrder,
                'data' => array_map(function($status) use ($statusCounts) {
                    return $statusCounts[$status] ?? 0;
                }, $statusOrder),
                'hasData' => array_sum($statusCounts) > 0
        ];

        return view('partner.report.show', compact('eventType', 'reportData'));
    }




    public function notifications()
    {
        return view('partner.notifications.show');
    }

    public function profile()
    {
        // Mendapatkan pengguna yang sedang login menggunakan guard 'partner'
        $user = Auth::guard('partner')->user();

        // Jika tidak ada pengguna yang login dengan guard 'partner', arahkan ke login
        if (!$user) {
            return redirect('/partner/login'); // Sesuaikan dengan route login partner Anda
        }

        // Mengirim data pengguna ke view
        return view('partner.profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        // Mendapatkan pengguna yang sedang login menggunakan guard 'partner'
        $user = Auth::guard('partner')->user();

        // Jika tidak ada pengguna yang login dengan guard 'partner', arahkan ke login
        if (!$user) {
            return redirect('/partner/login'); // Sesuaikan dengan route login partner Anda
        }

        // Memvalidasi data yang masuk dari form
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Pastikan email unik di tabel 'partners', kecuali untuk email partner saat ini
                // Ganti 'partners' jika provider 'partner' Anda menggunakan nama tabel lain
                Rule::unique('partners')->ignore($user->id),
            ],
        ]);

        // Memperbarui data pengguna
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Menyimpan perubahan ke database
        $user->save();

        // Mengarahkan kembali ke halaman profil dengan pesan sukses
        // Anda bisa menggunakan 'with()' untuk mengirimkan flash message
        return redirect()->route('partner.profile.show')->with('status', 'Profile updated successfully!');
    }


}
