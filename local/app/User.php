<?php

namespace Responsive;

use Illuminate\Notifications\Notifiable;
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
        'name', 'post_slug', 'email', 'password','gender','admin','phone','photo','provider', 'provider_id','country','address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function userPendingEarnings()
    {
        return $this->hasMany(UserEarning::class ,'user_id' ,'id')->where('cleared' ,0);
    }

    public function userClearedEarnings()
    {
        return $this->hasMany(UserEarning::class ,'user_id' ,'id')->where('cleared' ,1);
    }

    public function productOrder()
    {
        return $this->hasMany(ProductOrder::class ,'user_id' ,'id');
    }
}

