<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnSaleDetail extends Model
{
    //
     protected $fillable = [
        'return_sale_id',
        'product_id',
        'cost',
        'price',
        'quantity',
        'iva',
        'subtotal',
        'company_id',
    ];


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function returnsale(): BelongsTo
    {
        return $this->belongsTo(ReturnSale::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
