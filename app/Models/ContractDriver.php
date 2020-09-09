<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractDriver extends Model
{
    protected $table = 'contract_drivers';

    protected $fillable = [
        'name',
        'phone',
        'contract_id',
        'car_plate',
        'avatar',
        'car_name',
    ];

    public function contract() 
    {
        return $this->belongsTo(Contract::class);
    }
}
