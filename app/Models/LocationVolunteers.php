<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }


}
