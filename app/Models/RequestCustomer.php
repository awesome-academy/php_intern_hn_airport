<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCustomer extends Model
{   
    protected $table = 'request_customers';
    
    public function request() 
    {
        return $this->belongsTo(Request::class);
    }
}
