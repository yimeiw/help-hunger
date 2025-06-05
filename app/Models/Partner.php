<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partner';
    
    protected $fillable = [
        'partner_name',
        'partner_link',
        'type',
    ];
}
