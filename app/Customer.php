<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * Get the orders associated with the customer.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
