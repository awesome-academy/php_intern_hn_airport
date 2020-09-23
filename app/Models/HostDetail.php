<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostDetail extends Model
{
    protected $table = 'host_details';
    protected $fillable = [
        'province_id',
        'car_type_id',
        'user_id',
        'quantity',
    ];
    
    public function users() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function provinces() 
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function carTypes() 
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }
}
