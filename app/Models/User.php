<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'balance',
        'is_admin',
        'phone_number',
        'referral',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin',
        'is_blocked',
        'is_advert',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function watchedVideos()
    {
        return $this->hasMany(WatchedVideos::class);
    }

    public function investment()
    {
        return $this->hasOne(Investment::class);
    }

    public function referral()
    {
        return $this->hasOne(User::class, 'username', 'referral');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referral', 'username');
    }
}
