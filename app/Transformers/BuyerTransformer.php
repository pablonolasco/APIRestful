<?php

namespace App\Transformers;

use App\Buyer;
use App\User;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int)$buyer->id,
            'nombre' => (string)$buyer->name,
            'correo' => (string)$buyer->email,
            'verificado' => (int)$buyer->verified,
            'fechaCreacion' => (string)$buyer->created_at,
            'fechaActualizacion' => (string)$buyer->updated_at,
            'fechaEliminacion' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
        ];
    }
}
