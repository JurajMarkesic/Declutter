<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','image'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    public function stories()
    {
        return $this->hasMany('App\Story');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followee_id', 'follower_id')->withTimestamps();
    }


    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followee_id')->withTimestamps();
    }
}
