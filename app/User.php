<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','google_id','avatar','avatar_original','provider_id','product','token','refresh_token','href','expires_at','hr','finance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function award(){
        return $this->hasMany('App\Award');
    }

    public function deduct(){
        return $this->hasMany('App\Deduct');
    }

    public function bank(){
        return $this->hasOne('App\Bank');
    }

    public function payroll(){
        return $this->belongsTo('App\Payroll');
    }
}
