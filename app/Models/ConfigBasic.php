<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigBasic extends Model
{
    protected $table = 'config_basics';

    protected $fillable = [
        'car_type_id',
        'distance_id',
        'cost',
    ];

    public function configDistances()
    {
        return $this->belongsTo(ConfigDistance::class, 'distance_id');
    }

    public function carTypes()
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }
    
}
