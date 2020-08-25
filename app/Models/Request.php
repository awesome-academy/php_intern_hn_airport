<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public function users() 
    {
        return $this->belongsTo(User::class);
    }

    public function carTypes() 
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function provinceAirports() 
    {
        return $this->belongsTo(ProvincAirport::class, 'province_airport_id');
    }

    public function requestDestinations() 
    {
        return $this->hasMany(RequestDestination::class);
    }

    public function requestCustomer() 
    {
        return $this->hasOne(RequestCustomer::class);
    }

    public function contract() 
    {
        return $this->hasOne(Contract::class);
    }
}
