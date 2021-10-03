<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryProductController extends ApiController
{
    /**
     * TODO obtiene los productos por categoria
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        $products=$category->products;
        return $this->showAll($products);
    }
}
