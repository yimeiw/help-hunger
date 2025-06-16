<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donation;
use App\Models\Partner;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use App\Models\LocationVolunteers;
use App\Models\LocationDonatur;   
use App\Models\Notification;
use App\Models\Location; 
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\EventsDonationDetails;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function location(){
        return view('admin.location');
    }

    public function report(Request $request){
         // Inisialisasi variabel waktu dan collection
        $now = Carbon::now();
        $monthlyDonations = collect(); // Kumpulkan data donasi per bulan

        // --- Laporan Donasi per Bulan ---
        // Mendapatkan data donasi untuk 12 bulan terakhir
        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $label = $month->format('M Y');

            $total = Donation::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');

            $monthlyDonations->push([
                'label' => $label,
                'total' => $total,
            ]);
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
            ]
        ];

        return view('admin.report', compact('reportData')); // Membuat view baru untuk laporan
    }

    public function manage() {
        return view('admin.manage.manage');
    }

    public function showNotifications(Request $request)
    {
        $adminId = Auth::id();
        $now = Carbon::now();
        $notifications = Notification::where('user_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Tandai semua notifikasi sebagai dibaca
        Notification::where('user_id', $adminId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('admin.notification', compact('notifications', 'now'));
    }

    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return back()->with('success', 'Notification marked as read.');
    }

    public function manageUser(Request $request) {
        $role = $request->query('role');
        $query = User::query();

        if ($role === 'partner') {
            // Ambil data dari tabel partners
            $partners = Partner::paginate(10);

            return view('admin.manage-user', [
                'users' => null,
                'partners' => $partners,
                'role' => $role,
            ]);
        }


        $query->withCount([
            'volunteerActivities as total_volunteered_activities',
            'donationActivities as total_donated_activities'
        ]);

        if ($role && $role !== '') {
            $validRoles = ['admin', 'volunteer', 'donatur'];
            if (in_array($role, $validRoles)) {
                $query->where('role', $role);
            }
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10);

        return view('admin.manage-user', [
            'users' => $users,
            'partners' => null,
            'role' => $role,
        ]);
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    /**
     * Show the form for creating a new volunteer event.
     *
     * @return \Illuminate\View\View
     */
    public function createVolunteerEvent()
    {
        $partners = Partner::all();
        $provinces = Provinces::all();
        $locations = LocationVolunteers::all(); // Assuming a single Location model for both types
        return view('admin.manage.event.addVolunteer', compact('partners', 'locations', 'provinces'));
    }

    /**
     * Store a newly created volunteer event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEventVolunteer(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_volunteers' => 'required|integer|min:1',
            'current_needs' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'partner_id' => 'required|exists:partner,id',

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
            'partner_id' => $validatedData['partner_id'],
            'location_id' => $location->id, // Assign the newly created location's ID
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images/volunteer', 'public');
            $eventData['image_path'] = $imagePath;
        }

        // Admin menambahkan event, jadi status langsung 'accepted'
        $eventData['status'] = 'accepted';

        EventsVolunteers::create($eventData);

        dd($eventData);

        return redirect()->route('admin.manage-event', ['type' => 'volunteer'])->with('success', 'Volunteer event added successfully!');
    }

    /**
     * Show the form for creating a new donation event.
     *
     * @return \Illuminate\View\View
     */
    public function createDonationEvent()
    {
        $partners = Partner::all();
        $provinces = Provinces::all();
        $locations = LocationDonatur::all(); // Assuming a single Location model for both types
        return view('admin.manage.event.addDonation', compact('partners', 'locations', 'provinces'));
    }

    /**
     * Store a newly created donation event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEventDonation(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'donation_target' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'partner_id' => 'required|exists:partner,id',

            'location_name' => 'required|string|max:255',
            'location_address' => 'required|string|max:255',
            'location_zipcode' => 'required|digits:5', // Assuming 5-digit zipcode
            'province_id' => 'required|exists:provinces,id', // Validasi terhadap tabel provinces
            'city_id' => 'required|exists:cities,id',       // Validasi terhadap tabel cities
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $location = LocationDonatur::create([
            'name' => $validatedData['location_name'],
            'address' => $validatedData['location_address'],
            'zipcode' => $validatedData['location_zipcode'],
            'province_id' => $validatedData['province_id'],
            'city_id' => $validatedData['city_id'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        $eventData = [
            'event_name' => $validatedData['event_name'],
            'event_description' => $validatedData['event_description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'donation_target' => $validatedData['donation_target'],
            'partner_id' => $validatedData['partner_id'],
            'location_id' => $location->id, // Assign the newly created location's ID
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images/donation', 'public');
            $eventData['image_path'] = $imagePath;
        }

        // Admin menambahkan event, jadi status langsung 'accepted'
        $eventData['status'] = 'accepted';
        $partners = Partner::all();

        EventsDonatur::create($eventData);

        return redirect()->route('admin.manage-event', ['type' => 'donation'])->with('success', 'Donation event added successfully!');
    }

    public function manageEvent(Request $request) {
         $eventType = $request->get('type', 'volunteer'); // Default ke 'volunteer'

        if ($eventType === 'volunteer') {
            $query = EventsVolunteers::with('partner', 'location');
        } elseif ($eventType === 'donation') {
            $query = EventsDonatur::with('partner', 'location');
        } else {
            return redirect()->route('admin.manage-event', ['type' => 'volunteer']);
        }

        if ($request->has('partner_id') && $request->partner_id != '') {
            $query->where('partner_id', $request->partner_id);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('event_name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
            });
        }

        $events = $query->paginate(10);
        $partners = Partner::all();
        
        return view('admin.manage-event', compact('events', 'partners', 'eventType'));
    }

    public function deleteEventVolunteer($id) {
        $event = EventsVolunteers::findOrFail($id);
        $event->delete();
        return redirect()->back()->with('success', 'Event Volunteer successfully deleted.');
    }

    public function deleteEventDonation($id) {
         $event = EventsDonatur::findOrFail($id);
        $event->delete();
        return redirect()->back()->with('success', 'Event donation successfully deleted.');
    }

    public function manageLocation(Request $request)
    {
        $type = $request->get('type', 'volunteer');
        $search = $request->get('search');

        $Model = $this->getLocationModel($type);

        $locations = $Model::with(['province', 'city'])
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('address', 'like', "%$search%")
                      ->orWhere('zipcode', 'like', "%$search%")
                      ->orWhereHas('province', fn($q) => $q->where('province_name', 'like', "%$search%"))
                      ->orWhereHas('city', fn($q) => $q->where('cities_name', 'like', "%$search%"));
            })
            ->paginate(10);

        $provinces = Provinces::all();
        $cities = Cities::all();

        return view('admin.location', compact('locations', 'type', 'search', 'provinces', 'cities'));
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'province' => 'required|exists:provinces,id',
            'city' => 'required|exists:cities,id',
            'zipcode' => 'required|string|max:10',
            'type' => 'required|in:volunteer,donation,donatur',
        ]);

        $Model = $this->getLocationModel($request->type);

        $Model::create([
            'name' => $request->name,
            'address' => $request->address,
            'province_id' => $request->province,
            'city_id' => $request->city,
            'zipcode' => $request->zipcode,
            'latitude' => $city->latitude ?? 0.0,
            'longitude' => $city->longitude ?? 0.0,
        ]);

        return redirect()->route('admin.location', ['type' => $request->type])
                         ->with('success', 'Location added successfully!');
    }

    public function deleteLocation($id, Request $request)
    {
        $type = $request->get('type', 'volunteer');
        $Model = $this->getLocationModel($type);

        $location = $Model::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.location', ['type' => $type])
                         ->with('success', 'Location deleted successfully!');
    }

    private function getLocationModel($type)
    {
        return match($type) {
            'volunteer' => new LocationVolunteers,
            'donation' => new LocationDonation,
            'donatur' => new LocationDonatur,
            default => new LocationVolunteers,
        };
    }

    public function manageEventsApproval(Request $request)
    {
        $statistics = [
            'totalUsers' => User::count(),
            'totalVolunteers' => User::where('role', 'volunteer')->count(),
            'totalDonaturs' => User::where('role', 'donatur')->count(),
            'totalPartners' => Partner::count(),
            'totalDonationAmount' => Donation::sum('amount'),
            'totalEvents' => EventsVolunteers::count() + EventsDonatur::count(),
            'activeEvents' => EventsVolunteers::where('status', 'accepted')->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->count()
                            + EventsDonatur::where('status', 'accepted')->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->count(),
            'upcomingEvents' => EventsVolunteers::where('status', 'accepted')->whereDate('start_date', '>', now())->count()
                                + EventsDonatur::where('status', 'accepted')->whereDate('start_date', '>', now())->count(),
        ];

        $perPage = 10; // Number of items per page for pending events
        $page = $request->query('page', 1); // Current page from request, default to 1

        // --- Fetch and Combine PENDING Events ---
        $pendingVolunteerEvents = EventsVolunteers::with('partner', 'location')
            ->where('status', 'pending')
            ->get()
            ->map(function ($event) {
                $event->event_type = 'volunteer';
                return $event;
            });

        $pendingDonationEvents = EventsDonatur::with('partner', 'location')
            ->where('status', 'pending')
            ->get()
            ->map(function ($event) {
                $event->event_type = 'donation';
                return $event;
            });

        $allPendingEvents = $pendingVolunteerEvents->merge($pendingDonationEvents)->sortByDesc('created_at');

        // Manually paginate the merged collection
        $pendingEvents = new LengthAwarePaginator(
            $allPendingEvents->forPage($page, $perPage),
            $allPendingEvents->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );


        // --- Fetch and Combine ONGOING Events ---
        $now = Carbon::now();
        $ongoingVolunteerEvents = EventsVolunteers::with('partner', 'location')
            ->where('status', 'accepted')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->get()
            ->map(function ($event) {
                $event->event_type = 'volunteer';
                return $event;
            });

        $ongoingDonationEvents = EventsDonatur::with('partner', 'location')
            ->where('status', 'accepted')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->get()
            ->map(function ($event) {
                $event->event_type = 'donation';
                return $event;
            });
        $ongoingEvents = $ongoingVolunteerEvents->merge($ongoingDonationEvents)->sortBy('start_date');


        // --- Fetch and Combine COMPLETED Events ---
        $completedVolunteerEvents = EventsVolunteers::with('partner', 'location', 'eventsVolunteersDetails')
            ->where('status', 'accepted')
            ->where('end_date', '<', $now)
            ->get()
            ->map(function ($event) {
                $event->event_type = 'volunteer';
                return $event;
            });

        $completedDonationEvents = EventsDonatur::with('partner', 'location', 'donations')
            ->where('status', 'accepted')
            ->where('end_date', '<', $now)
            ->get()
            ->map(function ($event) {
                $event->event_type = 'donation';
                return $event;
            });
        $completedEvents = $completedVolunteerEvents->merge($completedDonationEvents)->sortByDesc('end_date');


        // --- Fetch and Combine DECLINED Events ---
        $declinedVolunteerEvents = EventsVolunteers::with('partner', 'location')
            ->where('status', 'rejected')
            ->get()
            ->map(function ($event) {
                $event->event_type = 'volunteer';
                return $event;
            });

        $declinedDonationEvents = EventsDonatur::with('partner', 'location')
            ->where('status', 'rejected')
            ->get()
            ->map(function ($event) {
                $event->event_type = 'donation';
                return $event;
            });
        $declinedEvents = $declinedVolunteerEvents->merge($declinedDonationEvents)->sortByDesc('updated_at');


        return view('admin.dashboard', compact(
            'statistics',
            'pendingEvents',
            'ongoingEvents',
            'completedEvents',
            'declinedEvents'
        ));
    }

    // approveEvent and declineEvent methods remain the same as before
    public function approveEvent($type, $id)
    {
        if ($type === 'volunteer') {
            $event = EventsVolunteers::findOrFail($id);
        } elseif ($type === 'donation') {
            $event = EventsDonatur::findOrFail($id);
        } else {
            return back()->with('error', 'Invalid event type.');
        }

        $event->status = 'accepted';
        $event->save();

        return back()->with('success', 'Event ' . $event->event_name . ' has been approved.');
    }

    public function declineEvent($type, $id)
    {
        if ($type === 'volunteer') {
            $event = EventsVolunteers::findOrFail($id);
        } elseif ($type === 'donation') {
            $event = EventsDonatur::findOrFail($id);
        } else {
            return back()->with('error', 'Invalid event type.');
        }

        $event->status = 'rejected';
        $event->save();

        return back()->with('success', 'Event ' . $event->event_name . ' has been declined.');
    }

}