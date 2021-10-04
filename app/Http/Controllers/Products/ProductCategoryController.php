<?php

namespace App\Http\Controllers\Products;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends ApiController
{
    /**
     * TODO obtener las categorias de un producto
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    /**
     * TODO actualizar una categoria al producto
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, Category $category)
    {
        // sync, attach, syncWithoutDetaching
        // $product->categories()->sync([$category->id]);// sustituye los registros por el actualizar
        //  $product->categories()->attach([$category->id]);// repite los elementos a actualizar
        $product->categories()->syncWithoutDetaching([$category->id]);// TODO agrega la categoria sin eliminar las que existen y sin duplicados
        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     * TODO quita la categoria del producto
     * @param \App\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product,Category $category)
    {
        //TODO busca que el id de la categoria este asociado a un producto
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('La categoria especificada no es una categoria de este producto',404);
        }
        $product->categories()->detach([$category->id]);

        return $this->showAll($product->categories);


    }
}
