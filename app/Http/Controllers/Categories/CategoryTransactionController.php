<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTransactionController extends ApiController
{
    /**
     * TODO obtiene la lista de transacciones por categoria
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        $transactions=$category->products()->whereHas('transactions')// TODO indicas que por lo menos el producto tenga una transaccion
                    ->with('transactions')
                    ->get()
                    ->pluck('transactions')
                    ->collapse();
        return $this->showAll($transactions);
    }

}