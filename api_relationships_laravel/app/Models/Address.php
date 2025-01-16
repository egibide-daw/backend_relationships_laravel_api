<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //use HasFactory;
    protected $fillable = [
        'zipcode', 'country',
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
