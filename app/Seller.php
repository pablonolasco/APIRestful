<?php

namespace App;

use App\Product;
class Seller extends User
{
    /**
     * TODO un vendedor tiene muchos productos
     * https://styde.net/laravel-6-doc-eloquent-relaciones/#one-to-many
     */
    public function products()
    {
        $this->hasMany(Product::class);
    }
}
