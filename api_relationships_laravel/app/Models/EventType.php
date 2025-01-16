<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $table="event_types";

    protected $fillable = [
        'description'
    ];
    public function events(){
        return $this->hasMany('App\Models\Event');
    }
}
