<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocationDonatur extends Model
{
    protected $table = 'location_donatur';

    protected $fillable = [
        'province_id',
        'name',
        'address',
        'zipcode',
        'latitude',
        'longitude',
    ];

    public function events_donatur()
    {
        return $this->hasMany(EventsDonatur::class, 'location_id');
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
