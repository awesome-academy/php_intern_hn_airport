<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_type_id',
        'province_airport_id',
        'pickup',
        'user_id',
        'status',
        'budget',
        'note',
    ];
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function carTypes() 
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function provinceAirports() 
    {
        return $this->belongsTo(ProvinceAirport::class, 'province_airport_id');
    }

    public function requestDestinations() 
    {
        return $this->hasMany(RequestDestination::class, 'request_id');
    }

    public function requestCustomer() 
    {
        return $this->hasOne(RequestCustomer::class);
    }

    public function contract() 
    {
        return $this->hasOne(Contract::class, 'request_id');
    }
}
