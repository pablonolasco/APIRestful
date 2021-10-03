<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $category = Category::all();
        return $this->showAll($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:1',
            'description' => 'required'
        ];
        $campos = $request->all();
        $this->validate($request, $rules);
        $category = Category::create($campos);
        return $this->showOne($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        // fill recibe los valoes que se van a actualizar
        // intersect 5.4 intersecta los paramateros
       $category->fill($request->intersect([
           'name',
           'description'
       ]));

       // si la instancia no ha cambiado
        if ($category->isClean()) {
            return $this->errorResponse('Se debe especificar un valor diferente para poder actualizar', 422);
        }
        $category->save();
        return $this->showOne($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category, 200);
    }
}
