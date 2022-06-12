<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id'
    ];

    /**
     * Get the products associated with the category.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_category');
    }
}
