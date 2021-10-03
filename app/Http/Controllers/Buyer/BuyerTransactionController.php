<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerTransactionController extends ApiController
{
    /**
     * TODO retorna la lista de transacciones del comprador
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
        $buyerTransactions=$buyer->transactions;
        return $this->showAll($buyerTransactions);
    }

}
