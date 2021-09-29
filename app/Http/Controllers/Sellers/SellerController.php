<?php

namespace App\Http\Controllers\Sellers;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *  TODO lista de vendedores
     */
    public function index()
    {
        $vendedores=Seller::has('products')->get();
        return response()->json(['data'=>$vendedores],200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $vendedor=Seller::has('products')->findOrFail($id);
        return response()->json(['data'=>$vendedor],200);
    }
}
