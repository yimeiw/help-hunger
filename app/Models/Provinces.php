<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $table = 'provinces';
    protected $fillable = [
        'province_name',
    ];

    public function cities()
    {
        return $this->hasMany(Cities::class);
    }

    public function location_donatur()
    {
        return $this->hasMany(LocationDonatur::class, 'province_id');
    }

    public function location_volunteers()
    {
        return $this->hasMany(LocationVolunteers::class, 'province_id');
    }
}
