<?php

namespace App;

use App\Buyer;
use App\Product;
use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    public $transformer= TransactionTransformer::class;

    protected $dates=['deleted_at'];
    //
    protected $fillable=[
        'quantity',
        'buyer_id',
        'product_id',
    ];

    /**
     * TODO una transaccion pertenece a un comprador
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    /**
     * TODO una transaccion pertence a un producto
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
