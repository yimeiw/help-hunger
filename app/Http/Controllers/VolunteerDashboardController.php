<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\EventsVolunteers;
use App\Models\LocationVolunteers;
use App\Models\EventsVolunteersDetail;
use App\Models\EventsDonatur;
use App\Models\Partner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View; 
use Carbon\Carbon; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use PDF;

class VolunteerDashboardController extends Controller
{
    public function about(){
        return view('volunteer.about.show');
    }

    public function locations(){
        return view('volunteer.locations.show');
    }

    public function searchLocations()
    {
        $zipcode = request()->input('zipcode');

        $locations = LocationVolunteers::with('events_volunteers.partner')
            ->where('zipcode', $zipcode)
            ->get();

        if ($locations->isNotEmpty()) {
            return view('volunteer.locations.search', compact('locations'));
        } else {
            return redirect()->back()->with('error', 'No locations found.');
        }
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

            // --- Your splitting logic (which is correct for the controller) ---
            if ($selectedEvent) { // Ensure an event was found before processing
                $description = $selectedEvent->event_description;

                // Split by two or more newlines
                $paragraphs = preg_split('/(\r?\n){2,}/', $description, 2);

                // Assign the first paragraph
                // Using strip_tags and nl2br might be useful if the description
                // doesn't explicitly use <p> tags but relies on newlines for paragraphs.
                $selectedEvent->first_paragraph = $paragraphs[0];

                // Assign the remaining description, if it exists
                $selectedEvent->remaining_description = isset($paragraphs[1]) && trim($paragraphs[1]) !== '' ? $paragraphs[1] : null;
            }
        }
        return view('volunteer.event.create', compact('events', 'selectedEvent'));
    }

    public function eventsRegisterLanding()
    {
        return view('volunteer.event.landing');
    }

    public function eventsRegisterStore(Request $request)
    {
        // 1. Validate the request
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events_volunteers,id',
        ]);

        if ($validator->fails()) {
            // Redirect back with validation errors if not an AJAX request
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. Find the event
        $event = EventsVolunteers::findOrFail($request->event_id);

        // 3. Get the authenticated user
        $authenticatedUser = Auth::user();

        if (!$authenticatedUser) {
            return redirect()->route('login')->with('error', 'Please log in to volunteer.');
        }

        // 4. Check for existing registration to prevent duplicates
        $existingRegistration = EventsVolunteersDetail::where('volunteer_id', $authenticatedUser->id)
                                                    ->where('event_id', $event->id)
                                                    ->first();

        if ($existingRegistration) {
            // Flash the 'show_loading' flag here too if you want the loading on this specific redirect
            return redirect()->route('volunteer.events.landing')
                             ->with('info', 'You have already registered for this event.')
                             ->with('show_loading', true); // Flash the loading flag
        }

        try {
            // 5. Create a new event detail entry (registration)
            $eventsDetail = new EventsVolunteersDetail();
            $eventsDetail->event_id = $event->id;
            $eventsDetail->volunteer_id = $authenticatedUser->id;
            $eventsDetail->save();

            $notification = new Notification();
            $notification->user_id = $authenticatedUser->id;
            $notification->title = 'Registration Confirmed for ' . $event->event_name;
            $notification->message = 'You have successfully registered as a volunteer for the ' . $event->event_name . ' event on ' . $event->start_date . ' until ' . $event->end_date . '.';
            $notification->is_read = false;
            $notification->created_at = now();
            $notification->save();
            

            // 6. Redirect with success message AND loading flag
            return redirect()->route('volunteer.events.landing')
                             ->with('success', 'Yay, you\'re officially a volunteer! Time to make the world a better place together ✨')
                             ->with('show_loading', true); // Flash the loading flag

        } catch (\Exception $e) {
            Log::error('Volunteer registration error: ' . $e->getMessage(), ['user_id' => $authenticatedUser->id, 'event_id' => $event->id]);
            return redirect()->back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }

    public function details(Request $request): View
    {
        $volunteerId = Auth::id();
        $filter = $request->query('filter', 'all');
        $now = Carbon::now();
        // dd($now->toDateString());

        // Debugging: Lihat nilai $now dan $now->toDateString()
        // dd('Current Carbon date:', $now, 'Current date string:', $now->toDateString());

        $query = EventsVolunteersDetail::with(['volunteer', 'event.location', 'event.partner'])
            ->where('volunteer_id', $volunteerId);

        // Menerapkan filter berdasarkan parameter 'filter'
        if ($filter == 'upcoming') {
            $query->whereHas('event', function ($q) use ($now) {
                // Debugging: Tambahkan dd() di sini untuk melihat query yang dihasilkan
                $q->whereDate('start_date', '>', $now->toDateString());
                // dd($q->toSql(), $q->getBindings());
            });
        } elseif ($filter == 'ongoing') {
            $query->whereHas('event', function ($q) use ($now) {
                // Debugging: Tambahkan dd() di sini
                $q->whereDate('start_date', '<=', $now->toDateString())
                ->whereDate('end_date', '>=', $now->toDateString());
                // dd($q->toSql(), $q->getBindings());
            });
        } elseif ($filter == 'done') {
            $query->whereHas('event', function ($q) use ($now) {
                // Debugging: Tambahkan dd() di sini
                $q->whereDate('end_date', '<', $now->toDateString());
                // dd($q->toSql(), $q->getBindings());
            });
        }

        $eventsDetail = $query->get();

        // Debugging: Lihat hasil akhir query setelah filter
        // dd($eventsDetail);

        return view('volunteer.details.show', compact('eventsDetail', 'filter'));
    }

    public function detailsEvents(Request $request): View
    {
        // Ambil semua event (mungkin untuk daftar di sidebar atau di tempat lain)
        // Variabel $events ini mungkin tidak digunakan langsung di view details.details,
        // tapi jika memang ada kebutuhan lain, biarkan saja.
        $events = EventsVolunteers::with(['partner', 'location'])->get();

        $selectedEvent = null;
        $volunteerParticipationStatus = null;

        $volunteerId = Auth::id();

        // Mengambil detail partisipasi relawan untuk user yang login
        // Eager load relasi 'volunteer', 'event.location', dan 'event.partner'
        $eventDetailsQuery = EventsVolunteersDetail::with(['volunteer', 'event.location', 'event.partner'])
            ->where('volunteer_id', $volunteerId);

        // Eksekusi query untuk mendapatkan semua event partisipasi user ini
        $eventDetails = $eventDetailsQuery->get();

        $now = Carbon::now(); // Dapatkan waktu sekarang

        // --- BAGIAN PENTING: Loop melalui setiap detail partisipasi untuk menambahkan properti yang dihitung ---
        foreach ($eventDetails as $detail) {
            // Periksa apakah event sudah selesai
            // Pastikan event memiliki end_date dan di-cast sebagai Carbon instance di model EventsVolunteers
            $detail->eventIsDone = Carbon::parse($detail->event->end_date)->isPast();

            // Tentukan apakah sertifikat bisa diunduh
            $detail->canDownloadCertificate = ($detail->eventIsDone);
        }
        // --- AKHIR BAGIAN PENTING ---


        // --- Logika untuk selectedEvent (jika ada event tertentu yang dipilih/dilihat detailnya) ---
        // Logika ini relevan jika view details.details juga menampilkan detail event spesifik
        // yang dipilih melalui query parameter 'event'.
        if ($request->has('event')) {
            $selectedEvent = EventsVolunteers::with(['location', 'partner'])->find($request->event);

            if ($selectedEvent) {
                // Pastikan end_date di-cast ke Carbon instance
                if (!($selectedEvent->end_date instanceof Carbon)) {
                    $selectedEvent->end_date = Carbon::parse($selectedEvent->end_date);
                }

                // Hitung total relawan untuk selectedEvent ini
                $totalVolunteers = EventsVolunteersDetail::where('event_id', $selectedEvent->id)->count();
                $selectedEvent->total_volunteers_count = $totalVolunteers;

                // Logika Pemisahan Deskripsi
                $description = $selectedEvent->event_description;
                $paragraphs = preg_split('/(\r?\n){2,}/', $description, 2);
                $selectedEvent->first_paragraph = $paragraphs[0];
                $selectedEvent->remaining_description = isset($paragraphs[1]) && trim($paragraphs[1]) !== '' ? $paragraphs[1] : null;

            }
        }

        // Kirim semua variabel yang diperlukan ke view
        return view('volunteer.details.details', compact('events', 'eventDetails', 'selectedEvent', 'now'));
    }


    public function cancelParticipation(Request $request, EventsVolunteers $event): RedirectResponse
    {
        $volunteerId = Auth::id();

        // Cari record partisipasi yang sesuai
        $participationRecord = EventsVolunteersDetail::where('event_id', $event->id)
                                                     ->where('volunteer_id', $volunteerId)
                                                     ->first();

        // Jika record partisipasi ditemukan, hapus
        if ($participationRecord) {
            $participationRecord->delete();
            // Berikan pesan sukses ke user
            return redirect()->route('volunteer.details.show')->with('success', 'Your participation in the event has been' . $event->event_name . ' successfully canceled.');
        }

        // Jika tidak ditemukan (misalnya sudah dibatalkan atau tidak pernah terdaftar)
        return redirect()->route('volunteer.details.show')->with('error', 'You are not registered for this event, or your participation has been cancelled.');
    }

    public function partner()
    {
        $partners = Partner::all();
        return view('volunteer.partner.show', compact('partners'));
    }

    public function notifications()
    {
        $volunteerId = Auth::id();
        $now = Carbon::now();
        $notifications = Notification::where('user_id', $volunteerId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Tandai semua notifikasi sebagai dibaca
        Notification::where('user_id', $volunteerId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('volunteer.notification.show', compact('notifications', 'now'));
    }

    public function downloadCertificate($detailId)
    {
        $authenticatedUser = Auth::user();

        if (!$authenticatedUser) {
            return redirect()->route('login')->with('error', 'Please log in to download your certificate.');
        }

        // Cari detail registrasi event
        $eventsDetail = EventsVolunteersDetail::where('id', $detailId)
                                            ->where('volunteer_id', $authenticatedUser->id)
                                            ->firstOrFail(); // Pastikan hanya pengguna yang bersangkutan yang bisa mengunduh

        // Pastikan statusnya 'accepted' dan event sudah selesai
        if ($eventsDetail->status !== 'accepted' || now()->lt($eventsDetail->event->end_date)) {
            return redirect()->back()->with('error', 'Certificate is not available for download yet.');
        }

        // Cek apakah sertifikat sudah ada
        if ($eventsDetail->certificate_path && Storage::disk('public')->exists($eventsDetail->certificate_path)) {
            return Storage::disk('public')->download($eventsDetail->certificate_path);
        }

        // Jika sertifikat belum ada, generate
        try {
            $eventName = $eventsDetail->event->event_name;
            $volunteerName = $authenticatedUser->name; // Asumsi nama volunteer ada di model User
            $startDate = \Carbon\Carbon::parse($eventsDetail->event->start_date)->format('d F Y');
            $endDate = \Carbon\Carbon::parse($eventsDetail->event->end_date)->format('d F Y');
            $issueDate = now()->format('d F Y');

            $data = [
                'volunteerName' => $volunteerName,
                'eventName' => $eventName,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'issueDate' => $issueDate,
            ];

            $pdf = PDF::loadView('certifications.volunteer.show', $data);

            // Tentukan nama file
            $fileName = 'certificate_' . str_replace(' ', '_', $volunteerName) . '_' . str_replace(' ', '_', $eventName) . '.pdf';
            $filePath = 'certificates/' . $fileName;

            // Simpan PDF ke storage
            Storage::disk('public')->put($filePath, $pdf->output());

            // Update path sertifikat di database
            $eventsDetail->certificate_path = $filePath;
            $eventsDetail->save();

            // Unduh file PDF
            return Storage::disk('public')->download($filePath);

        } catch (\Exception $e) {
            Log::error('Error generating certificate: ' . $e->getMessage(), ['detail_id' => $detailId, 'user_id' => $authenticatedUser->id]);
            // dd($e->getMessage(), $e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to generate certificate. Please try again later.');
        }
    }
}
