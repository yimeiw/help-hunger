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
        'donation_target',
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
                    ->withTimestamps();
    }

    public function successfulDonations()
    {
        return $this->hasMany(Donation::class, 'event_id')
                    ->where('payment_status', 'success');
    }

    public function getTotalDonationAmountAttribute()
    {
        return $this->donations()->where('payment_status', 'success')->sum('amount');
    }

    public function getDonationCountAttribute()
    {
        return $this->donations()->where('payment_status', 'success')->count();
    }
}
