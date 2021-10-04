<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use function foo\func;

class ProductBuyerTransactionController extends ApiController
{
    /**
     * TODO Metodo que realiza una transaccion enviando el producto, comprador
     * @param Request $request
     * @param Product $product
     * @param User $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('El comprador debe ser diferente al vendedor ', 409);
        }

        if (!$buyer->esVerificado()) {
            return $this->errorResponse('El comprador debe ser un usuario verificado ', 409);
        }

        if (!$product->seller->esVerificado()) {
            return $this->errorResponse('El vendedor debe ser un usuario verificado ', 409);
        }
        if (!$product->estaDisponible()) {
            return $this->errorResponse('El producto para esta transaccion no esta disponible ', 409);
        }
        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('El producto no tiene la cantidad disponible requerida para esta transaccion', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            // TODO funcion que realiza el registro de la transaccion
            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);
            return $this->showOne($transaction);
        });

    }


}
