<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customer';
    public function reward()
    {
        return $this->hasOne('App\Models\Reward', 'customer_id', 'customer_id');
    }
}