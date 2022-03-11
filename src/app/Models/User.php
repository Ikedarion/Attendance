<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

<<<<<<< HEAD
    public function shops_reservations()
    {
        return $this->belongsToMany(Shop::class, 'reservations')->withPivot('id', 'date', 'time', 'number');
    }

    public function shops_likes()
    {
        return $this->belongsToMany(Shop::class, 'likes')->withPivot('id');
=======
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
>>>>>>> fe7f3d706bcc8ea2c91a437dcd571d401b4d1d29
    }
}
