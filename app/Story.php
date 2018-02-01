<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'item_id', 'user_id', 'story', 'cost'
    ];

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function owner()
    {
        return $this->belongsTo('App\User');
    }
}
