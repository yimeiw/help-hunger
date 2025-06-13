<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    protected $table = 'partner';
    
    protected $fillable = [
        'province_id',
        'city_id',
        'partner_name',
        'partner_email',
        'password',
        'partner_link',
        'type',
    ];
    
    public function accounts()
    {
        return $this->hasMany(PartnerAccounts::class);
    }
}
