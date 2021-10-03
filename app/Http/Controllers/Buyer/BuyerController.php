<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *  TODO lista de compradores
     */
    public function index()
    {
        // obtiene la funcion con la relacion del modelo transactions
        $compradores=Buyer::has('transactions')->get();
        //return response()->json(['data'=>$compradores],200);
        return $this->showAll($compradores);
    }

    /**
     * @param Buyer $buyer inyeccion de dependecia implicita
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Buyer $buyer)
    {
        //$comprador=Buyer::has('transactions')->findOrFail($id);
        //return response()->json(['data'=>$comprador],200);
        return  $this->showOne($buyer,200);

    }
}
