<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerCategoryController extends ApiController
{
    /**
     * TODO obtiene las categorias del vendedor
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        $categories=$seller->products()->with('categories')->get()->pluck('categories')->collapse()->unique('id')->values();
        return $this->showAll($categories);
    }

}
