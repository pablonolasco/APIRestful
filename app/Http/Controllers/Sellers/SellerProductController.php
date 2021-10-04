<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * TODO controlador que realiza las operaciones entre seller y product
 * Class SellerProductController
 * @package App\Http\Controllers\Sellers
 */
class SellerProductController extends ApiController
{
    /**
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    /**
     * @param Request $request
     * @param User $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        $data['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        $data['image'] = $request->image->store('');//TODO almacena la imagen en la ruta store, al dejar vacio laravel se encarga del nombre unico
        $data['seller_id'] = $seller->id;
        $product = Product::create($data);

        return $this->showOne($product, 201);
    }

    /**
     * TODO actualiza al producto
     * @param Request $request
     * @param Seller $seller
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::PRODUCTO_DISPONIBLE . ',' . Product::PRODUCTO_NO_DISPONIBLE,
            'image' => 'image'
        ];
        $this->validate($request, $rules);

        $this->verificarVendedor($seller,$product);

        $product->fill($request->intersect([
            'name',
            'description',
            'quantity'
        ]));

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->estaDisponible() && $product->categories()->count() == 0) {
                return $this->errorResponse('Un producto debe al menos tener una categoria',409);
            }
        }

        if($request->hasFile('image')){
            Storage::delete($product->image);
            $product->image=$request->image->store('');
        }

        if ($product->isClean()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * @param Seller $seller
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Seller $seller,Product $product)
    {
        $this->verificarVendedor($seller,$product);
        //TODO ingresa a la ruta laravel
        Storage::delete($product->image);
        $product->delete();
        return $this->showOne($product);
        //
    }

    /**
     * TODO metodo que valida si el vendedor es el propietario del producto
     *
     * @param Seller $seller
     * @param Product $product
     */
    public function verificarVendedor(Seller $seller,Product $product){
        if ($seller->id != $product->seller_id) {
            throw new HttpException(422,'El vendedor especificado no es el vendedor del producto');
        }
    }
}
