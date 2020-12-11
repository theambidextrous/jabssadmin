<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'address',
        'city',
        'state',
        'zip',
        'email',
        'phone',
        'password',
        'user_type',
        'pic',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function format_us_number($no)
    {
        $nn = preg_replace("/[^0-9]/", "", $no);
        $a = '+1(' . substr($nn, 0, 3) . ') ';
        $b = substr($nn, 3, 3) . '-';
        $c = substr($nn, -4);
        return $a.$b.$c;
    }
}
