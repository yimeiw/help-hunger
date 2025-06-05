<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsDonationDetails extends Model
{
protected $table = 'events_donation_details';
    protected $fillable = [
        'event_id',
        'donation_id',
        'donation_target',
    ];
    public function event()
    {
        return $this->belongsTo(EventsDonatur::class, 'event_id');
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
