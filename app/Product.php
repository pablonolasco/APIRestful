<?php

namespace App;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Transaction;
use App\Seller;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];
    //
    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';
    public $transformer= ProductTransformer::class;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    // TODO oculta la tabla pivote de los resultados
    protected $hidden=['pivot'];
    /**
     * @return bool retorna el estatus del producto
     */
    public function estaDisponible()
    {
        return $this->status == Product::PRODUCTO_DISPONIBLE;
    }

    /**
     * @Las relaciones de muchos-a-muchos son definidas
     * escribiendo un método que devuelve el resultado del método belongsToMany.
     * https://styde.net/laravel-6-doc-eloquent-relaciones/#many-to-many
     * TODO muchos producto tiene muchas categorias
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * TODO un producto possee muchas transacciones
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * TODO Podemos definir el inverso de una relación hasOne usando el método belongsTo:
     * TODO y es porque lleva la llave foranea seller_id
     * un producto pertenece a un vendedor
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
