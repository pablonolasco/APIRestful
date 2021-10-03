<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerSellerController extends ApiController
{
    /**
     * TODO obtiene los vendedores de los productos de las compras
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
        $sellers=$buyer->transactions()->with('product')
                    ->get()
                    ->pluck('product.seller')// TODO ingresa a la colleccion por medio del . de esta manera accedera a seller
                    ->unique('id')// TODO obtendra solo los sellers unicos por id
                    ->values();// TODO regorganiza los indices de la collections para quitar los elementos vacios
        //dd($sellers);
        return $this->showAll($sellers);
    }
}
