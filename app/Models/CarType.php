<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $table = 'car_types';
    
    public function requests() 
    {
        return $this->hasMany(Request::class, 'car_type_id');
    }

    public function hostDetails() 
    {
        return $this->hasMany(HostDetail::class, 'car_type_id');
    }

    public function configBasics()
    {
        return $this->hasMany(ConfigBasic::class, 'car_type_id');
    }
}
