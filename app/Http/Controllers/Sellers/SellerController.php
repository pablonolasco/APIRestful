<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *  TODO lista de vendedores
     */
    public function index()
    {
        $vendedores=Seller::has('products')->get();
        //return response()->json(['data'=>$vendedores],200);
        return $this->showAll($vendedores);
    }

    /**
     * @param Seller $seller inyecion de dependencia implicita
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Seller $seller)
    {
       // $vendedor=Seller::has('products')->findOrFail($id);
        //return response()->json(['data'=>$vendedor],200);
        return $this->showOne($seller,200);
    }
}
