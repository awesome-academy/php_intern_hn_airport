<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{   
    use SoftDeletes;
    
    protected $fillable = [
        'request_id',
        'supplier_id',
        'pickup',
        'status',
    ];

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
