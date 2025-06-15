<?php

namespace App\Http\Controllers;

use App\Models\EventsVolunteersDetail;
use App\Models\EventsVolunteers;
use App\Models\EventsDonatur;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\Snappy\Facades\SnappyPdf;

class CertificateController extends Controller
{
    public function downloadCertificate($eventType, $eventId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to download your certificate.');
        }

        if ($eventType === 'volunteer') {
            // Ambil detail dan relasi ke EventsVolunteers
            $detail = EventsVolunteersDetail::with(['event', 'event.partner'])
                ->where('event_id', $eventId)
                ->where('volunteer_id', $user->id)
                ->firstOrFail();

            $eventVolunteer = EventsVolunteers::findOrFail($eventId);
            $eventName = $eventVolunteer->event_name;

        } elseif ($eventType === 'donation') {
            // Ambil detail dan relasi ke EventsDonatur
            $detail = Donation::with(['event', 'event.partner'])
                ->where('event_id', $eventId)
                ->where('donatur_id', $user->id)
                ->firstOrFail();

            $eventDonatur = EventsDonatur::findOrFail($eventId);
            $eventName = $eventDonatur->event_name;

        } else {
            abort(404, 'Invalid event type.');
        }

        $partner = $detail->event->partner;

        // Cek signature partner
        $partnerSignaturePath = public_path("signatures/partner_{$partner->id}.svg");
        if (!file_exists($partnerSignaturePath)) {
            $partnerSignaturePath = public_path("assets/sertif/ttd.svg");
        }

        $data = [
            'participantName' => $user->name,
            'eventName' => $eventName,
            'startDate' => \Carbon\Carbon::parse($detail->event->start_date)->format('F j, Y'),
            'endDate' => \Carbon\Carbon::parse($detail->event->end_date)->format('F j, Y'),
            'issueDate' => now()->format('F j, Y'),
            'is_volunteer' => $eventType === 'volunteer',

            'eventOrganizer' => (object)[
                'name' => $partner->partner_name,
                'title' => match ($partner->type) {
                    'community' => 'Community Partner',
                    'ngo' => 'NGO Partner',
                    'orphanage' => 'Orphanage Partner',
                    default => 'Event Partner',
                }
            ],
            'advisorHelpHunger' => (object)[
                'name' => 'HelpHunger Advisor',
                'title' => 'Advisor'
            ],

            // Asset paths
            'eventOrganizerSignaturePath' => $partnerSignaturePath,
            'advisorSignaturePath' => public_path('assets/sertif/ttd.svg'),
            'helphungerLogoPath' => public_path('assets/sertif/logo-serti.svg'),
            'decorativeLinePath' => public_path('assets/sertif/line-serti.svg'),
            'tl_border_path' => public_path('assets/sertif/boarder-kiri-atas.svg'),
            'tr_border_path' => public_path('assets/sertif/boarder-kanan-atas.svg'),
            'bl_border_path' => public_path('assets/sertif/boarder-kiri-bawah.svg'),
            'br_border_path' => public_path('assets/sertif/boarder-kanan-bawah.svg'),
        ];

        // Generate PDF via Snappy (wkhtmltopdf)
        $pdf = \Barryvdh\Snappy\Facades\SnappyPdf::loadView('certifications.download', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->inline("certificate_{$user->name}.pdf");
    }

}
