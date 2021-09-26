<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
class Category extends Model
{
    // asignacion masiva fillable
    protected $fillable=['name','description'];

    /**
     * @Las relaciones de muchos-a-muchos son definidas
     * escribiendo un método que devuelve el resultado del método belongsToMany.
     * https://styde.net/laravel-6-doc-eloquent-relaciones/#many-to-many
     * TODO muchas categoria esta en muchos productos
     */
    public function products()
    {
        $this->belongsToMany(Product::class);
    }

}
