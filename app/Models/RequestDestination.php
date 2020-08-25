<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestDestination extends Model
{   
    protected $table = 'request_destinations';

    public function requests() 
    {
        return $this->belongsTo(Request::class);
    }
}
