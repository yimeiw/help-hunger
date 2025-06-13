<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'province_id',
        'cities_name',
    ];

    public function province()
    {
        return $this->belongsTo(Provinces::class);
    }
}
