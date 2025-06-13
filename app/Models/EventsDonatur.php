<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsDonatur extends Model
{
    protected $table = 'events_donatur';

    protected $fillable = [
        'event_name',
        'event_description',
        'start_date',
        'end_date',
        'status',
        'partner_id',
        'location_id',
        'image_path',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function location()
    {
        return $this->belongsTo(LocationDonatur::class);
    }

    public function donations()
    {
        return $this->belongsToMany(Donation::class, 'events_donation_details', 'event_id', 'donation_id')
                    ->withPivot('donation_target')
                    ->withTimestamps();
    }

    public function getTotalDonationAmountAttribute()
    {
        return $this->donations()->where('payment_status', 'success')->sum('amount');
    }

    public function getDonationCountAttribute()
    {
        return $this->donations()->where('payment_status', 'success')->count();
    }
    
    public function getTotalDonationTargetAttribute()
    {
        return $this->donations->sum(fn($donation) => $donation->pivot->donation_target);
    }


}
