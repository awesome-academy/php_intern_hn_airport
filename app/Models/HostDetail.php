<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class HostDetail extends Model
{
    protected $table = 'host_details';
    
    public function users() 
    {
        return $this->belongsTo(User::class);
    }

    public function provinces() 
    {
        return $this->belongsTo(Province::class);
    }

    public function carTypes() 
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }
}
