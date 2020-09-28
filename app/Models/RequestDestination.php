<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestDestination extends Model
{   
    protected $table = 'request_destinations';

    protected $fillable = [
        'request_id',
        'type',
        'location',
    ];

    public function requests() 
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}
