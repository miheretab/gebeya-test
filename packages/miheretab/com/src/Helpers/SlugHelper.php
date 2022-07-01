<?php

namespace Miheretab\Com\Helpers;

use App\Product;
use App\Category;
use Validator;

class SlugHelper {

    public static function generateSlug($name, $model = 'categories', $addExt = false) {
        $slug = "";

        $slug = strtolower($name);
        $slug = str_replace(' ', '-', $name); // Replaces all spaces with hyphens.
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);

        if ($addExt) {
            $slug .= '1';
        }

        // do while slug validates
        $validator = Validator::make(['slug' => $slug], [
            'slug' => "unique:$model"
        ]);

        if ($validator->fails()) {
            return self::generateSlug($slug, $model, true);
        }

        return $slug;
    }

}