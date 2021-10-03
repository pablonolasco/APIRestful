<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerTransactionController extends ApiController
{
    /**
     * TODO obtiene las transacciondes del vendedor
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        $transaction=$seller->products()
                    ->whereHas('transactions')
                    ->with('transactions')
                    ->get()
                    ->pluck('transactions')
                    ->collapse();
        return $this->showAll($transaction);
    }

}
