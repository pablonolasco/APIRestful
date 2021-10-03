<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transaction;

class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tranctions=Transaction::all();
        return $this->showAll($tranctions);
    }


    /**
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }

}
