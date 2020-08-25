<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvinceAirport extends Model
{   
    protected $table = 'province_airports';
    
    public function provinces() 
    {
        return $this->belongsTo(Province::class, 'province_airport_id');
    }

    public function requests() 
    {
        return $this->hasMany(Request::class, 'province_airport_id');
    }
}
