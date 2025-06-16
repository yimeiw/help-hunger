<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\LocationDonatur;
use App\Models\EventsDonatur;
use App\Models\EventsDonationDetails;
use App\Models\Partner;
use App\Models\PartnerAccounts;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View; 
use Carbon\Carbon; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use PDF;

class DonaturDashboardController extends Controller
{
    public function about(){
        return view('donatur.about.show');
    }
    
    public function locations(){
        return view('donatur.locations.show');
    }
    
    public function searchLocations()
    {
        $zipcode = request()->input('zipcode');
        
        $locations = LocationDonatur::with('events_donatur.partner')
        ->where('zipcode', $zipcode)
        ->get();
        
        if ($locations->isNotEmpty()) {
            return view('donatur.locations.search', compact('locations'));
        } else {
            return redirect()->back()->with('error', 'No locations found.');
        }
    }
    
    
    public function donations()
    {
        // Eager load 'partner', 'location', dan 'successfulDonations'
        $events = EventsDonatur::with(['partner', 'location', 'successfulDonations'])
                               ->where('status', 'accepted') // <-- TAMBAHKAN BARIS INI
                                  ->where('status', 'accepted') // <-- TAMBAHKAN BARIS INI
                               ->get();

        // Sekarang, hitung total donasi dan jumlah donasi yang sukses
        foreach ($events as $event) {
            $event->total_donation_amount = $event->successfulDonations->sum('amount');
            $event->donation_count = $event->successfulDonations->count();
        }

        return view('donatur.donations.show', compact('events'));
    }
    
    
    public function donationsRegister(Request $request)
    {
        $event = null;
        $canDonate = false;

        if ($request->has('event')) {
            $event = EventsDonatur::with(['location', 'partner', 'donations'])->find($request->event);

            if ($event) {
                // Carbon::now() akan otomatis menyesuaikan dengan timezone di config/app.php
                // Jika Anda telah mengatur 'timezone' => 'Asia/Jakarta' di config/app.php,
                // maka $now akan berada dalam zona waktu WIB.
                $now = Carbon::now();

                // start_date dan end_date dari database biasanya tidak memiliki informasi waktu,
                // jadi Carbon::parse() akan mengasumsikan 00:00:00 untuk tanggal tersebut.
                // startOfDay() dan endOfDay() memastikan rentang waktu mencakup seluruh hari.
                // Mereka akan menggunakan timezone default aplikasi.
                $startDate = Carbon::parse($event->start_date)->startOfDay();
                $endDate = Carbon::parse($event->end_date)->endOfDay();

                // Debugging baris ini (Anda bisa hapus setelah memastikan berfungsi)
                // dd($now, $startDate, $endDate, $now->between($startDate, $endDate));

                // Logika: Bisa donasi jika tanggal sekarang berada di antara start_date dan end_date (inklusif)
                $canDonate = $now->between($startDate, $endDate);

                // Jika ingin event juga harus memiliki status 'accepted'
                // $canDonate = $now->between($startDate, $endDate) && $event->status === 'accepted';

                $description = $event->event_description;
                $paragraphs = preg_split('/(\r?\n){2,}/', $description, 2);
                $event->first_paragraph = $paragraphs[0];
                $event->remaining_description = isset($paragraphs[1]) && trim($paragraphs[1]) !== '' ? $paragraphs[1] : null;
            }
        }

        return view('donatur.donations.create', compact('event', 'canDonate'));
    }


    public function donationsRegisterLanding()
    {
        return view('donatur.donations.landing');
    }

    
    public function donationsRegisterStore(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'event_id' => 'required|exists:events_donatur,id',
            'payment_method' => 'required|string|in:BCA,Master Card,Link Aja',
        ]);

        $donaturId = Auth::id();
        if (!$donaturId) {
            return redirect()->back()->with('error', 'Silakan login untuk membuat donasi.');
        }

        try {
            // Temukan event dan pastikan partner terkaitnya dimuat
            $event = EventsDonatur::with('partner')->findOrFail($validatedData['event_id']);

            // Temukan detail rekening partner yang sesuai dengan metode pembayaran yang dipilih
            // Asumsi partner punya minimal satu rekening. Jika tidak, tambahkan pengecekan error.
            $partnerAccount = PartnerAccounts::where('partner_id', $event->partner->id)
                                            ->where('rekening_type', $validatedData['payment_method'])
                                            ->first();

            if (!$partnerAccount) {
                // Ini bisa terjadi jika partner tidak memiliki rekening dengan metode yang dipilih
                throw new \Exception('Nomor rekening untuk metode pembayaran yang dipilih tidak ditemukan.');
            }

            // Tambahkan ini - ambil data event terlebih dahulu
            $event = EventsDonatur::findOrFail($validatedData['event_id']);
            
            $donation = Donation::create([
                'amount' => $validatedData['amount'],
                'payment_status' => 'pending', // Status awal selalu 'pending'
                'payment_date' => now(), // Atau null jika pembayaran belum terjadi
                'payment_method' => $validatedData['payment_method'],
                'donatur_id' => $donaturId,
                'event_id' => $validatedData['event_id'],
            ]);
            // dd($donation->toArray(), 'Donasi objek dibuat di memori. Cek id-nya. Jika id null, berarti mass assignment gagal.');


            $user = Auth::user(); // Dapatkan data user yang terautentikasi
            $formattedAmount = number_format($validatedData['amount'], 0, ',', '.');

            // 3. Buat notifikasi untuk donatur
            $notification = new Notification();
            $notification->user_id = $donaturId; // Pastikan kolom donatur_id ada di tabel notifikasi Anda
            $notification->partner_id = null; // Tambahkan partner_id jika relevan
            $notification->title = 'Donasi Dicatat untuk ' . $event->event_name;
            $notification->message = 'Terima kasih atas donasi Anda sebesar IDR ' . number_format($validatedData['amount'], 0, ',', '.') . ' untuk event ' . $event->event_name . '. Silakan selesaikan pembayaran.';
            $notification->is_read = false;
            $notification->save();

            return redirect()->route('donatur.donations.confirm', [
                'donation_id' => $donation->id, // Kirim ID donasi yang baru dibuat
            ])->with([
                'success' => 'Donasi Anda telah dicatat! Silakan selesaikan pembayaran.',
                'show_loading' => true // Jika Anda memiliki loading screen
            ]);

        } catch (\Exception $e) {
            \Log::error('Kesalahan pendaftaran donasi: ' . $e->getMessage(), [
                'donatur_id' => $donaturId,
                'event_id' => $validatedData['event_id'],
                'trace' => $e->getTraceAsString() // Tambahkan trace untuk debugging lebih lanjut
            ]);
            // dd($e->getMessage(), $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses donasi Anda. Silakan coba lagi.')->withInput();
        }
    }



    // --- Metode baru untuk menampilkan halaman konfirmasi pembayaran ---
    public function showDonationConfirmation($donation_id)
    {
        $donation = Donation::with(['event.partner.accounts'])->findOrFail($donation_id);

        // Cari detail rekening yang relevan dengan metode pembayaran donasi ini
        $partnerAccount = $donation->event->partner->accounts->firstWhere('rekening_type', $donation->payment_method);

        if (!$partnerAccount) {
            // Tangani kasus jika rekening tidak ditemukan (walaupun seharusnya sudah ada)
            return redirect()->route('donatur.donations.landing')->with('error', 'Detail rekening pembayaran tidak ditemukan.');
        }

        return view('donatur.donations.confirm', compact('donation', 'partnerAccount'));
    }

    // --- Metode baru untuk menangani unggahan bukti pembayaran ---
    public function uploadPaymentProof(Request $request, $donation_id)
    {
        $validatedData = $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Maks 2MB
        ]);

        $donation = Donation::findOrFail($donation_id);

        if ($request->hasFile('payment_proof')) {
            $image = $request->file('payment_proof');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $filePath = $image->storeAs('payment_proofs', $fileName, 'public'); // Simpan di storage/app/public/payment_proofs

            $donation->payment_proof = $filePath;
            // Anda mungkin ingin mengubah status menjadi 'waiting_for_verification'
            // jika ada status perantara sebelum 'success'
            $donation->payment_status = 'pending'; // Status baru
            $donation->save();

            // Opsional: Kirim notifikasi ke admin bahwa ada bukti transfer baru
            // atau notifikasi ke donatur bahwa bukti telah diterima

            return redirect()->route('donatur.donations.landing')
                             ->with('success', 'Bukti pembayaran Anda telah berhasil diunggah dan sedang menunggu verifikasi.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }


    public function details(Request $request): View{
        $donaturId = Auth::id(); // Ini adalah ID dari user/donatur yang sedang login

        // Query untuk mendapatkan SEMUA event yang diikuti oleh donatur ini
        // Kita harus memfilter melalui relasi 'donation'
        $allParticipatedEventsQuery = EventsDonationDetails::whereHas('donation', function($q) use ($donaturId) {
            $q->where('donatur_id', $donaturId);
        });
        $totalParticipatedEvents = $allParticipatedEventsQuery->count(); // Hitung jumlahnya

        // Query utama yang akan difilter berdasarkan tanggal
        $query = EventsDonationDetails::with(['donation', 'event.location', 'event.partner'])
            // Hapus baris ->where('donation_id', $donaturId); yang salah
            // Ganti dengan whereHas untuk memfilter berdasarkan donatur_id di tabel 'donations'
            ->whereHas('donation', function($q) use ($donaturId) {
                $q->where('donatur_id', $donaturId);
            });


        $filter = $request->query('filter', 'all');
        $now = Carbon::now();

        // Menerapkan filter berdasarkan parameter 'filter'
        if ($filter == 'upcoming') {
            $query->whereHas('event', function ($q) use ($now) {
                $q->whereDate('start_date', '>', $now->toDateString());
            });
        } elseif ($filter == 'ongoing') {
            $query->whereHas('event', function ($q) use ($now) {
                $q->whereDate('start_date', '<=', $now->toDateString())
                  ->whereDate('end_date', '>=', $now->toDateString());
            });
        } elseif ($filter == 'done') {
            $query->whereHas('event', function ($q) use ($now) {
                $q->whereDate('end_date', '<', $now->toDateString());
            });
        }

        $eventsDetail = $query->get();

        // Dapatkan jumlah event yang muncul setelah difilter (bukan total semua event)
        $filteredEventCount = $eventsDetail->count();

        return view('donatur.details.show', compact('eventsDetail', 'filter', 'filteredEventCount'));
    }

    public function detailsEvents(Request $request): View{
        $donaturId = Auth::id(); // ID dari user yang sedang login (sebagai Donatur)
        $now = Carbon::now();

        // --- 1. Mendapatkan daftar partisipasi donasi spesifik untuk donatur yang login ---
        // Kita ingin mendapatkan EventsDonationDetails yang terkait dengan donasi
        // yang dibuat oleh donatur ini.
        $eventParticipationDetails = EventsDonationDetails::with([
                'donation' => function ($query) use ($donaturId) {
                    $query->where('donatur_id', $donaturId); // Filter donasi berdasarkan donatur yang login
                },
                'event.location',
                'event.partner'
            ])
            ->whereHas('donation', function ($query) use ($donaturId) {
                $query->where('donatur_id', $donaturId); // Pastikan EventsDonationDetails terkait donasi dari donatur ini
            })
            ->get();

        // Filter out details where the 'donation' relation might be null after the whereHas filter
        $eventDetails = $eventParticipationDetails->filter(function ($detail) {
            return $detail->donation !== null;
        });


        // --- 2. Menghitung status setiap partisipasi (Upcoming, Ongoing, Done) ---
        foreach ($eventDetails as $detail) {
            $eventStartDate = Carbon::parse($detail->event->start_date);
            $eventEndDate = Carbon::parse($detail->event->end_date);

            $detail->eventIsUpcoming = $eventStartDate->gt($now);
            $detail->eventIsDone = $eventEndDate->lt($now);
            $detail->eventIsOngoing = $eventStartDate->lte($now) && $eventEndDate->gte($now);
            $detail->eventStatusLabel = ''; // Untuk menampilkan di Blade

            if ($detail->eventIsUpcoming) {
                $detail->eventStatusLabel = 'Upcoming';
            } elseif ($detail->eventIsOngoing) {
                $detail->eventStatusLabel = 'Ongoing';
            } elseif ($detail->eventIsDone) {
                $detail->eventStatusLabel = 'Done';
            } else {
                $detail->eventStatusLabel = 'Unknown'; // Fallback
            }

            // Tentukan apakah sertifikat bisa diunduh
            // Umumnya sertifikat hanya bisa diunduh jika event sudah Selesai
            $detail->canDownloadCertificate = ($detail->eventIsDone);
        }

        // --- 3. Logika untuk selectedEvent (Jika user mengklik event tertentu untuk melihat detailnya) ---
        $selectedEvent = null;
        $totalDonatedAmountByYou = 0; // Total donasi yang diberikan oleh donatur untuk selectedEvent ini
        $totalDonationsCountForEvent = 0; // Total donasi (jumlah transaksi) untuk selectedEvent ini

        if ($request->has('event')) {
            $selectedEventId = $request->event;
            $selectedEvent = EventsDonatur::with(['location', 'partner'])->find($selectedEventId);

            if ($selectedEvent) {
                // Pastikan tanggal di-cast ke Carbon instance di model EventsDonatur
                // Idealnya ini sudah di-handle oleh $casts di model EventsDonatur
                if (!($selectedEvent->start_date instanceof Carbon)) {
                    $selectedEvent->start_date = Carbon::parse($selectedEvent->start_date);
                }
                if (!($selectedEvent->end_date instanceof Carbon)) {
                    $selectedEvent->end_date = Carbon::parse($selectedEvent->end_date);
                }

                // Hitung total donasi yang masuk ke selectedEvent (dari semua donatur, status sukses)
                // Asumsi: Anda punya relasi 'successfulDonations' di EventsDonatur model (seperti yang saya sarankan sebelumnya)
                // Atau eager load saja relasi 'donations' dan filter di sini
                $totalDonationsCollected = Donation::where('event_id', $selectedEventId)
                                                   ->where('payment_status', 'success')
                                                   ->sum('amount');
                $selectedEvent->total_donations_collected_amount = $totalDonationsCollected;

                // Hitung total jumlah donasi (transaksi) yang sukses untuk event ini
                $totalDonationsCountForEvent = Donation::where('event_id', $selectedEventId)
                                                        ->where('payment_status', 'success')
                                                        ->count();
                $selectedEvent->total_donations_count_for_event = $totalDonationsCountForEvent;


                // Hitung total donasi yang diberikan OLEH donatur yang sedang login untuk selectedEvent ini
                $totalDonatedAmountByYou = Donation::where('event_id', $selectedEventId)
                                                   ->where('donatur_id', $donaturId)
                                                   ->where('payment_status', 'success') // Hanya donasi sukses
                                                   ->sum('amount');

                // Logika Pemisahan Deskripsi
                $description = $selectedEvent->event_description;
                $paragraphs = preg_split('/(\r?\n){2,}/', $description, 2);
                $selectedEvent->first_paragraph = $paragraphs[0];
                $selectedEvent->remaining_description = isset($paragraphs[1]) && trim($paragraphs[1]) !== '' ? $paragraphs[1] : null;

                // Ambil Status Partisipasi donatur ini untuk selectedEvent ini
                // Ini akan mendapatkan record EventsDonationDetails yang dibuat oleh donasi donatur ini ke event ini
                $participationRecord = EventsDonationDetails::where('event_id', $selectedEventId)
                                                            ->whereHas('donation', function($q) use ($donaturId) {
                                                                $q->where('donatur_id', $donaturId);
                                                            })
                                                            ->first();

                // Variabel ini bisa menunjukkan apakah user sudah berpartisipasi di event ini
                // Atau, jika ada status di EventsDonationDetails, bisa ditampilkan
                $userParticipatedInSelectedEvent = ($participationRecord !== null);
                // Jika EventsDonationDetails memiliki kolom 'status' yang relevan:
                // $donationParticipationStatus = $participationRecord->status ?? null;
            }
        }

        // Variabel $events di sini akan berisi semua EventsDonatur.
        // Jika tidak digunakan di view donatur.details.details, bisa dihapus atau di-fetch sesuai kebutuhan.
        $events = EventsDonatur::with(['partner', 'location'])->get();


        // Kirim semua variabel yang diperlukan ke view
        return view('donatur.details.details', compact(
            'events', // Jika masih diperlukan
            'eventDetails', // Semua partisipasi donatur ini
            'selectedEvent', // Detail event yang sedang dilihat
            'totalDonatedAmountByYou', // Total donasi user ini untuk selectedEvent
            'totalDonationsCountForEvent', // Total jumlah donasi sukses untuk selectedEvent (dari semua donatur)
            'now' // Waktu sekarang
            // '$userParticipatedInSelectedEvent' atau '$donationParticipationStatus' jika relevan
        ));
    }


    public function partner()
    {
        $partners = Partner::all();
        return view('volunteer.partner.show', compact('partners'));
    }

    public function notifications()
    {
        $donaturId = Auth::id();
        $now = Carbon::now();
        $notifications = Notification::where('volunteer_id', $donaturId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Tandai semua notifikasi sebagai dibaca
        Notification::where('volunteer_id', $donaturId)
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

        // Find the event registration detail, ensuring it belongs to the authenticated user.
        // If not found or not owned, firstOrFail() will throw a 404.
        $eventsDetail = EventsDonationDetails::where('events_donation_details.id', $detailId)
            ->whereHas('donation', function ($query) use ($authenticatedUser) {
                $query->where('donatur_id', $authenticatedUser->id); // Assuming 'user_id' is on your 'Donation' model
            })
            ->firstOrFail();

        // Check if the event has actually ended. If not, the certificate isn't available.
        if (now()->lt($eventsDetail->event->end_date)) {
            return redirect()->back()->with('error', 'Certificate is not available for download yet. The event has not ended.');
        }

        // --- NEW LOGIC FOR ONE CERTIFICATE PER EVENT PER DONATUR ---
        // Before generating a new certificate, check if ANY donation by this user for THIS event already has a certificate.
        // This assumes your User model has a 'donations' relationship.
        $existingCertificateDonation = $authenticatedUser->donations()
            ->where('event_id', $eventsDetail->event->id)
            ->whereNotNull('certificate_path')
            ->first(); // Get the first donation for this event by this user that has a certificate path

        if ($existingCertificateDonation && Storage::disk('public')->exists($existingCertificateDonation->certificate_path)) {
            // If an existing certificate is found, download that one instead of generating a new one.
            return Storage::disk('public')->download($existingCertificateDonation->certificate_path);
        }
        // --- END NEW LOGIC ---

        // If we reach here, it means no certificate exists for this user for this event,
        // so we proceed to generate one.
        try {
            $eventName = $eventsDetail->event->event_name;
            $donaturName = $authenticatedUser->name;
            $role = $authenticatedUser->role;
            $startDate = Carbon::parse($eventsDetail->event->start_date)->format('d F Y');
            $endDate = Carbon::parse($eventsDetail->event->end_date)->format('d F Y');
            $issueDate = now()->format('d F Y');

            $partnerName = null;
            $partnerType = null;

            if ($eventsDetail->event->partner) {
                $partnerName = $eventsDetail->event->partner->partner_name;
                $partnerType = $eventsDetail->event->partner->type;
            }

            $data = [
                'donaturName' => $donaturName,
                'role' => $role,
                'eventName' => $eventName,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'issueDate' => $issueDate,
                'partnerName' => $partnerName,
                'partnerType' => $partnerType,
            ];

            $htmlContent = view('certifications.donatur.show', $data)->render();
            file_put_contents(storage_path('app/public/debug_certificate.html'), $htmlContent); // Simpan ke storage
            $pdf = PDF::loadView('certifications.donatur.show', $data)
                  ->setPaper('A4', 'landscape')
                  ->setOptions(['isRemoteEnabled' => true]);

            // Tentukan nama file yang unik untuk setiap sertifikat
            // Menggunakan ID donasi sebagai bagian dari nama file memastikan keunikan
            $fileName = 'certificate_' . str_replace(' ', '_', $donaturName) . '_' . str_replace(' ', '_', $eventName) . '_' . $eventsDetail->donation->id . '.pdf';
            $filePath = 'certificates/' . $fileName;

            // Simpan PDF ke storage
            Storage::disk('public')->put($filePath, $pdf->output());

            // Update path sertifikat di model Donation yang terkait
            $eventsDetail->donation->certificate_path = $filePath;
            $eventsDetail->donation->save();

            // Unduh file PDF
            return Storage::disk('public')->download($filePath);

        } catch (\Exception $e) {
            // Log the full error for debugging in server logs
            Log::error('Error generating certificate: ' . $e->getMessage(), [
                'detail_id' => $detailId,
                'donatur_id' => $authenticatedUser->id,
                'exception_trace' => $e->getTraceAsString(), // Add full trace for more context
            ]);

            // For development, you can use dd() to see the error immediately.
            // For production, remove/comment out dd() and rely on the redirect with error message.
            dd($e->getMessage());

            return redirect()->back()->with('error', 'Failed to generate certificate. Please try again later.');
        }
    }
    

}
