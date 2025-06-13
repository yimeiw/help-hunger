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
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function storeEventVolunteer(Request $request) {
        $request->validate([
            'event_name' => 'required',
            'partner_id' => 'required',
            'location_id' => 'required',
            'description' => 'required',
        ]);
        EventsVolunteers::create($request->all());
        return back()->with('success', 'Event volunteer berhasil ditambahkan.');
    }

    public function storeEventDonation(Request $request) {
        $request->validate([
            'event_name' => 'required',
            'partner_id' => 'required',
            'location_id' => 'required',
            'description' => 'required',
        ]);
        EventsDonatur::create($request->all());
        return back()->with('success', 'Event donasi berhasil ditambahkan.');
    }

    private function getLocationModel($type)
    {
        return match ($type) {
            'volunteer' => LocationVolunteers::class,
            'donation', 'donatur' => LocationDonatur::class,
            default => abort(404),
        };
    }

    public function manageLocation(Request $request)
    {
        $type = $request->query('type', 'volunteer');
        $Model = $this->getLocationModel($type);

        $locations = $Model::with(['province', 'city'])->paginate(10);

        return view('admin.location', [
            'locations' => $locations,
            'locationType' => $type,
        ]);
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
            'type' => 'required|in:volunteer,donation,donatur',
        ]);

        $Model = $this->getLocationModel($request->type);

        $Model::create($request->only([
            'name', 'address', 'province', 'city', 'zipcode'
        ]));

        return redirect()->route('admin.location', ['type' => $request->type])
                        ->with('success', 'Lokasi berhasil ditambahkan.');
    }


}