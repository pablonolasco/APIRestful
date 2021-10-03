<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryBuyerController extends ApiController
{
    /**
     * TODO obtiene los compradores de una categoria
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        $buyers=$category->products()->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()// TODO se unenen las collections
            ->pluck('buyer')//TODO se accede al elemento buyer
            ->unique()
            ->values();

        return $this->showAll($buyers);

    }

}
