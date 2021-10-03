<?php


namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class BuyerScope
 * @package App\Scopes Global Scopes
 * TODO Query Scopes; el término al español significa Ámbitos de Consulta y es justamente lo que nos permite, el trabajar haciendo consultas
 * TODO a la Base de datos en diferentes ámbitos y creando determinadas restricciones en la consulta que buscamos hacer.
 */

class BuyerScope implements Scope
{

    /**
     * TODO metodo para especificar la restricción que necesitamos hacer.
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
        $builder->has('transactions');
    }
}