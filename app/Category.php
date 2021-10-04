<?php

namespace App;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];
    public $transformer= CategoryTransformer::class;

    // asignacion masiva fillable
    protected $fillable=['name','description'];

    // TODO oculta la tabla pivote de los resultados
    protected $hidden=['pivot'];
    /**
     * @Las relaciones de muchos-a-muchos son definidas
     * escribiendo un método que devuelve el resultado del método belongsToMany.
     * https://styde.net/laravel-6-doc-eloquent-relaciones/#many-to-many
     * TODO muchas categoria esta en muchos productos
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
