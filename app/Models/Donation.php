<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donation';

    protected $fillable = [
        'donatur_id',
        'event_id',
        'amount',
        'payment_status',
        'payment_date',
        'payment_proof',
        'payment_method',
        'certificate_path',
        'receipt_url',
        'transaction_reference',
    ];

    public function donatur()
    {
        return $this->belongsTo(User::class, 'donatur_id');
    }

    public function event()
    {
        return $this->belongsTo(EventsDonatur::class, 'event_id');
    }

    public function eventDonatur()
    {
        return $this->belongsTo(EventsDonatur::class, 'event_id');
    }
}
