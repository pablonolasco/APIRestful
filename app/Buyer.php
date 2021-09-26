<?php

namespace App;

use App\Transaction;
class Buyer extends User
{
    //
    /**
     * @relacion one to many
     * Una relación de «uno-a-muchos» es usada para definir relaciones donde un solo
     * modelo posee cualquier cantidad de otros modelos. Por ejemplo,
     * un post de un blog puede tener un número infinito de comentarios.
     * Al igual que todas las demás relaciones de Eloquent, las relaciones
     * uno-a-muchos son definidas al colocar una función en tu modelo Eloquent
     * https://styde.net/laravel-6-doc-eloquent-relaciones/#one-to-many
     * TODO un comprador tiene muchas transacciones
     */
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
