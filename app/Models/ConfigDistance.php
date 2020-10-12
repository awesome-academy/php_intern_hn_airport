<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigDistance extends Model
{
    protected $table = 'config_distances';
    
    public function configBasics()
    {
        return $this->hasMany(ConfigBasic::class, 'distance_id');
    }
}
