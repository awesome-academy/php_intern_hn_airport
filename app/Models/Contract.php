<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public function request() 
    {
        return $this->belongsTo(Request::class);
    }

    public function contractDriver() 
    {
        return $this->hasOne(ContractDriver::class);
    }

    public function users() 
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
}
