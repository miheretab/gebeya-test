<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'quantity', 'image', 'user_id', 'slug'
    ];

    /**
     * Get the user associated with the product.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

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
