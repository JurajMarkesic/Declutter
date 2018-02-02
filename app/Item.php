<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use Searchable;

    protected $fillable = [
        'name', 'image', 'declutters', 'category_id'
    ];

    public function stories()
    {
        return $this->hasMany('App\Story');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
