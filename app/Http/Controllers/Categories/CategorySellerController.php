<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategorySellerController extends ApiController
{
    /**
     * TODO obtiene los vendedores por categoria
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        $sellers=$category->products()->with('seller')
                    ->get()
                    ->pluck('seller')
                    ->unique()
                    ->values();

        return $this->showAll($sellers);
    }

}