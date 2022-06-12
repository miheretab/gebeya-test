<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Get the orders associated with the product.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Get the categories associated with the product.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'product_category');
    }
}
