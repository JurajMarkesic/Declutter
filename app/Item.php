<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use Searchable;

    protected $fillable = [
        'name', 'image', 'declutters'
    ];

    public function stories()
    {
        return $this->hasMany('App\Story');
    }
}
