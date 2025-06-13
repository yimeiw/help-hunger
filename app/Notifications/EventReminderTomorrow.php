<?php
// app/Notifications/EventReminderTomorrow.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\EventsVolunteers; // Pastikan ini model event Anda

class EventReminderTomorrow extends Notification implements ShouldQueue
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
        return ['database']; // Notifikasi akan disimpan di database
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
                    ->subject('Pengingat Penting: Event Besok!')
                    ->line('Halo ' . $notifiable->name . ',')
                    ->line('Pemberitahuan penting! Event sukarelawan "' . $this->event->event_name . '" Anda dijadwalkan besok!')
                    ->line('Lokasi: ' . $this->event->location->location_name)
                    ->line('Tanggal: ' . $this->event->start_date->format('d F Y') . ' - ' . $this->event->end_date->format('d F Y'))
                    ->action('Lihat Detail Event', url('/volunteer/events/details?event=' . $this->event->id))
                    ->line('Sampai jumpa di sana!');
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
            'title' => 'Pengingat: Event Besok!',
            'message' => 'Event sukarelawan "' . $this->event->event_name . '" di ' . $this->event->location->location_name . ' dimulai besok. Bersiaplah!',
            'type' => 'event_reminder_tomorrow', // Tambahkan tipe untuk identifikasi
        ];
    }
}
