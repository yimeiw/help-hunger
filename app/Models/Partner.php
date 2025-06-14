<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model; // <-- Hapus atau komentar baris ini
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Gunakan ini
use Illuminate\Notifications\Notifiable; // <-- Tambahkan ini untuk fungsionalitas notifikasi (misal reset password)

class Partner extends Authenticatable // <-- Ubah dari Model menjadi Authenticatable
{
    use HasFactory, Notifiable; // <-- Tambahkan Notifiable di sini juga

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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Jika Anda menggunakan fitur "remember me"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ akan otomatis hash password jika ada ini
    ];

    public function accounts()
    {
        return $this->hasMany(PartnerAccounts::class);
    }
}