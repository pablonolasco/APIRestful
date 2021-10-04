<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $seller)
    {
        return [
            'identifier' => (int)$seller->id,
            'nombre' => (string)$seller->name,
            'correo' => (string)$seller->email,
            'verificado' => (int)$seller->verified,
            'fechaCreacion' => (string)$seller->created_at,
            'fechaActualizacion' => (string)$seller->updated_at,
            'fechaEliminacion' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
        ];
    }
}
