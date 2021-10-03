<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerBuyerController extends ApiController
{
    /**
     * TODO obtiene los compradores de un vendedor
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        $buyers=$seller->products()
            ->whereHas('transactions')//TODO verificamos que solo se obtengas los productos con trasacciones
            ->with('transactions.buyer')//TODO se obtiene el comprador de cada transaccion mediante la relacion
            ->get()//TODO obtenemos la data
            ->pluck('transactions')//TODO accedemos a la collections de transaccion
            ->collapse()// TODO se unenen las collections porque un vendedor puede tener asociados muchos productos a muchas transacciones
            ->pluck('buyer')//TODO se accede al elemento buyer
            ->unique()//TODO solo valores unicos
            ->values();//TODO se elminan los indices vacios

        return $this->showAll($buyers);
    }

}