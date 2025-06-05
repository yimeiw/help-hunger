<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationVolunteers extends Model
{
    protected $table = 'location_volunteers';

    protected $fillable = [
        'province_id',
        'name',
        'address',
        'zipcode',
        'latitude',
        'longitude',
    ];

    public function events_volunteers()
    {
        return $this->hasMany(EventsVolunteers::class, 'location_id');
    }

    public function province()
    {
        return $this->belongsTo(Provinces::class, 'province_id');
    }


}
