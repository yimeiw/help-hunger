<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\EventsVolunteersDetail;
use App\Models\EventsDonationDetails;
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\Donation;
use App\Models\Notification;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'province_id',
        'city_id',
        'name',
        'username',
        'phone',
        'email',
        'password',
        'role',
        'gender',
        'date_of_birth',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function province()
    {
        return $this->belongsTo(Provinces::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'user_id');
    }

    public function volunteerActivities()
    {
        return $this->hasMany(EventsVolunteersDetail::class, 'volunteer_id');
    }

    public function donationActivities()
    {
        return $this->hasMany(EventsDonationDetails::class, 'donation_id');
    }

    public function eventVolunteersDetails()
    {
        return $this->hasMany(EventsVolunteersDetail::class, 'volunteer_id');
    }

    public function eventDonaturDetails()
    {
        return $this->hasMany(EventsDonationDetail::class, 'donation_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin'; 
    }

    public function isVolunteer()
    {
        return $this->role === 'volunteer';
    }

    public function isDonatur()
    {
        return $this->role === 'donatur';
    }

    //sebagai volunteer
    public function volunteeredEvents()
    {
        return $this->belongsToMany(EventsVolunteers::class, 'events_volunteers_detail', 'volunteer_id',     'event_id')->withPivot('status')
                   ->withTimestamps();
    }

    public function donatedEvents()
    {
        return $this->belongsToMany(EventsDonatur::class, 'events_donation_details', 'donation_id',     'event_id')->withPivot('donation_target')
                   ->withTimestamps();
    }

    //sebagai donatur
    public function donatur()
    {
        return $this->hasMany(Donation::class, 'donatur_id');
    }

}
