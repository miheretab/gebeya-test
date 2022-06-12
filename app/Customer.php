<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address'
    ];

    /**
     * Get the orders associated with the customer.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
