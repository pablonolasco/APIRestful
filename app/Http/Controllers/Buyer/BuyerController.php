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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $comprador=Buyer::has('transactions')->findOrFail($id);
        //return response()->json(['data'=>$comprador],200);
        return  $this->showOne($comprador,200);

    }
}
