<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractDriver extends Model
{
    protected $table = 'contract_drivers';

    public function contract() 
    {
        return $this->belongsTo(Contract::class);
    }
}
