<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *  TODO lista de usuarios
     */
    public function index()
    {
        // obtiene la funcion con la relacion del modelo transactions
        $compradores=Buyer::has('transactions')->get();
        return response()->json(['data'=>$compradores],200);
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
        return response()->json(['data'=>$comprador],200);

    }
}
