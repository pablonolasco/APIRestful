<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier' => (int)$product->id,
            'titulo' => (string)$product->name,
            'detalles' => (string)$product->description,
            'disponibles' => (int)$product->quantity,
            'estado' => (int)$product->status,
            'imagen' => url("img/{$product->image}"),//TODO accede a la ruta del proyecto
            'vendedor' => (int)$product->seller_id,
            'fechaCreacion' => (string)$product->created_at,
            'fechaActualizacion' => (string)$product->updated_at,
            'fechaEliminacion' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
        ];
    }
}
