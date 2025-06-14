<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsVolunteers extends Model
{
    protected $table = 'events_volunteers';

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

    protected $casts = [
        'start_date' => 'date', // atau 'datetime' jika ada waktu
        'end_date' => 'date',   // atau 'datetime' jika ada waktu
    ];    

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function location()
    {
        return $this->belongsTo(LocationVolunteers::class, 'location_id');
    }

    public function volunteers()
    {
        return $this->belongsToMany(User::class, 'events_volunteers_detail', 'event_id', 'volunteer_id')
                    ->withTimestamps();
    }

    public function getVolunteerCountAttribute()
    {
        return $this->volunteers()->count();
    }

    public function eventsVolunteersDetails()
    {
        return $this->hasMany(EventsVolunteersDetail::class, 'event_id');
    }

}
