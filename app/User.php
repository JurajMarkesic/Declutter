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
}
