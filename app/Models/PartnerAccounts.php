<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartnerAccounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'rekening_type',
        'no_rekening',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

}
