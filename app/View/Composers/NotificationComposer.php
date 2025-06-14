<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification as CustomNotification; // Alias model notifikasi kustom Anda

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $unreadNotificationsCount = 0; // Default count
        
        // Pastikan pengguna sudah login sebelum mencoba mengambil notifikasi
        if (Auth::check()) {
            $volunteerId = Auth::id();
            // Ambil jumlah notifikasi yang belum dibaca dari tabel 'notification' kustom Anda
            $unreadNotificationsCount = CustomNotification::where('volunteer_id', $volunteerId)
                                                          ->where('is_read', false)
                                                          ->count();
        }

        // Teruskan variabel $unreadNotificationsCount ke view
        $view->with('unreadNotificationsCount', $unreadNotificationsCount);
    }
}
