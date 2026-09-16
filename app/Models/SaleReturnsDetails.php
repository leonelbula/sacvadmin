<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleReturnsDetails extends Model
{
    protected $fillable = [
        'sale_return_id',
        'product_id',
        'sale_detail_id',
        'quantity',
        'price',
        'cost',
        'subtotal',
    ];

    /*
    |--------------------------------------------------------------------------
    | Devolución
    |--------------------------------------------------------------------------
    */

    public function saleReturn(): BelongsTo
    {
        return $this->belongsTo(SaleReturn::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Producto
    |--------------------------------------------------------------------------
    */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Detalle de la venta original
    |--------------------------------------------------------------------------
    */

    public function saleDetail(): BelongsTo
    {
        return $this->belongsTo(SaleDetail::class);
    }
}
