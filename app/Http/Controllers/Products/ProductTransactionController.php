<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductTransactionController extends ApiController
{
    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Product $product)
    {
        $transaccions=$product->transactions;
        return $this->showAll($transaccions);
    }

}
