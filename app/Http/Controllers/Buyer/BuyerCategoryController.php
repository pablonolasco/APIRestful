<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerCategoryController extends ApiController
{
    /**
     * TODO obtiene las categorias de los productos de una compra
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
        $categories=$buyer->transactions()->with('product.categories')
            ->get()
            ->pluck('product.categories')//TODO obtiene la collection especificada
            ->collapse() // TODO une las collections
            ->unique('id')
            ->values();
        //dd($categories);
        return $this->showAll($categories);
    }

}
