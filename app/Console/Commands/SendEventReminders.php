<?php
// app/Console/Commands/SendEventReminders.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventsVolunteers; // Model event Anda
use App\Models\User;             // Model User Anda
use App\Models\Notification as CustomNotification; // Alias model notifikasi kustom Anda
use Carbon\Carbon;

class SendEventReminders extends Command
{
    /**
     * Nama perintah yang akan kita panggil.
     *
     * @var string
     */
    protected $signature = 'reminders:check-events';

    /**
     * Deskripsi perintah.
     *
     * @var string
     */
    protected $description = 'Mengecek event yang akan datang (3 hari atau besok) dan mengirim pengingat ke tabel notifikasi kustom.';

    /**
     * Jalankan perintah ini.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        $threeDaysFromNow = Carbon::today()->addDays(3);
        $tomorrow = Carbon::tomorrow();

        // Cari event yang dimulai dalam 3 hari ke depan
        // Eager load 'location' relationship
        $eventsThreeDays = EventsVolunteers::with('location')->whereDate('start_date', $threeDaysFromNow)->get();
        foreach ($eventsThreeDays as $event) {
            $this->sendReminder($event, 'three_days', $today);
        }

        // Cari event yang dimulai besok
        // Eager load 'location' relationship
        $eventsTomorrow = EventsVolunteers::with('location')->whereDate('start_date', $tomorrow)->get();
        foreach ($eventsTomorrow as $event) {
            $this->sendReminder($event, 'tomorrow', $today);
        }

        $this->info('Pengecekan dan pengiriman pengingat event selesai.');
        return Command::SUCCESS;
    }

    /**
     * Mengirim notifikasi ke relawan terdaftar untuk event tertentu.
     *
     * @param EventsVolunteers $event
     * @param string $type
     * @param Carbon $today
     * @return void
     */
    protected function sendReminder(EventsVolunteers $event, string $type, Carbon $today)
    {
        $this->info("Memeriksa pengingat {$type} untuk event: {$event->event_name}");

        // Dapatkan semua relawan yang terdaftar untuk event ini DENGAN STATUS 'accepted'
        $registeredVolunteers = User::whereHas('volunteeredEvents', function ($query) use ($event) {
            $query->where('event_id', $event->id)
                  ->where('status', 'accepted'); // <-- BARIS INI DITAMBAHKAN
        })->get();

        foreach ($registeredVolunteers as $volunteer) {
            // Tentukan judul dan pesan notifikasi
            $title = '';
            $message = '';

            if ($type === 'tomorrow') {
                $title = 'Reminder: "' . $event->event_name .'" is Tomorrow!';
                $message = 'Don\'t forget, you\'re scheduled to volunteer for the "' . $event->event_name . '" event tomorrow on ' . $event->start_date->format('DD:M:YYYY:HH:mm') . ', at ' . ($event->location->name ?? 'Unknown Location') . '. Please be prepared!';
            } elseif ($type === 'three_days') {
                $title = 'Reminder: "' . $event->event_name .' in 3 Days!';
                $message = 'Don\'t forget, you\'re scheduled to volunteer for the "' . $event->event_name . '" event in 3 days on ' . $event->start_date->format('DD:M:YYYY:HH:mm') . ', at ' . ($event->location->name ?? 'Unknown Location') . '. Please be prepared!';
            }
            
            // Cek apakah relawan ini sudah menerima notifikasi jenis ini untuk event ini hari ini
            $alreadyNotified = CustomNotification::where('volunteer_id', $volunteer->id)
                                                 ->where('title', $title) // Cek berdasarkan judul
                                                 ->whereDate('created_at', $today)
                                                 ->exists();

            if (!$alreadyNotified) { 
                try {
                    $customNotification = new CustomNotification();
                    $customNotification->volunteer_id = $volunteer->id;
                    $customNotification->title = $title;
                    $customNotification->message = $message;
                    $customNotification->is_read = false; // Default belum dibaca
                    $customNotification->save(); // Simpan ke database Anda

                    $this->info("Mengirim pengingat {$type} kepada relawan {$volunteer->name} untuk event {$event->event_name}.");
                } catch (\Exception $e) {
                    $this->error("Gagal menyimpan notifikasi untuk relawan {$volunteer->name} (Event ID: {$event->id}): " . $e->getMessage());
                    \Log::error("Gagal menyimpan notifikasi pengingat: " . $e->getMessage(), [
                        'volunteer_id' => $volunteer->id,
                        'event_id' => $event->id,
                        'notification_title' => $title,
                        'notification_message' => $message
                    ]);
                }
            } else {
                $this->warn("Relawan {$volunteer->name} sudah menerima pengingat {$type} untuk event {$event->event_name} hari ini.");
            }
        }
    }
}
