<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price', 'quantity', 'product_id', 'customer_id', 'status'
    ];

    /**
     * Get the product associated with the order.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * Get the customer associated with the order.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
