<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCustomer extends Model
{   
    protected $table = 'request_customers';

    protected $fillable = [
        'name',
        'phone',
        'request_id',
    ];
    
    public function request() 
    {
        return $this->belongsTo(Request::class);
    }
}
