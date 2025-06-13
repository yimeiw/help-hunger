<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsVolunteersDetail extends Model
{
    protected $table = 'events_volunteers_detail';
    protected $fillable = [
        'event_id',
        'volunteer_id',
    ];
    public function event()
    {
        return $this->belongsTo(EventsVolunteers::class, 'event_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }
}
