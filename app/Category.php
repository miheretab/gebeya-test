<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Get the products associated with the category.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_category');
    }
}
