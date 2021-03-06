<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user',
        'cardname',
        'mask',
        'pan',
        'exp',
        'fingerprint',
        'pciprint',
        'isdefault',
        'bank',
        'bankcode',
        'bankcountry',
        'bankstate',
        'cardtype',
        'icon',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}
