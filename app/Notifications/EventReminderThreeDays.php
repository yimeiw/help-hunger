<?php
// app/Notifications/EventReminderThreeDays.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\EventsVolunteers; // Pastikan ini model event Anda

class EventReminderThreeDays extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    /**
     * Buat instance notifikasi baru.
     *
     * @param EventsVolunteers $event
     * @return void
     */
    public function __construct(EventsVolunteers $event)
    {
        $this->event = $event;
    }

    /**
     * Dapatkan saluran pengiriman notifikasi.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Notifikasi akan disimpan di database (untuk notifikasi di aplikasi)
        // Jika Anda ingin mengirim email, tambahkan 'mail' ke array: ['database', 'mail']
        return ['database'];
    }

    /**
     * Dapatkan representasi email dari notifikasi.
     * (Opsional, jika Anda mengaktifkan saluran 'mail')
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pengingat Event Mendatang: ' . $this->event->event_name)
                    ->line('Halo ' . $notifiable->name . ',')
                    ->line('Ini pengingat! Event sukarelawan "' . $this->event->event_name . '" Anda akan segera dimulai dalam 3 hari.')
                    ->line('Lokasi: ' . $this->event->location->location_name)
                    ->line('Tanggal: ' . $this->event->start_date->format('d F Y') . ' - ' . $this->event->end_date->format('d F Y'))
                    ->action('Lihat Detail Event', url('/volunteer/events/details?event=' . $this->event->id))
                    ->line('Terima kasih atas dedikasi Anda!');
    }

    /**
     * Dapatkan representasi array dari notifikasi untuk penyimpanan database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'event_name' => $this->event->event_name,
            'title' => 'Pengingat: Event dalam 3 Hari!',
            'message' => 'Event sukarelawan "' . $this->event->event_name . '" di ' . $this->event->location->location_name . ' dimulai dalam 3 hari. Bersiaplah!',
            'type' => 'event_reminder_3_days', // Tambahkan tipe untuk identifikasi
        ];
    }
}