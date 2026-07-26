<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Kardex extends Model
{


    protected $fillable = [
        'date',
        'movement_type',
        'origin',
        'reference_id',
        'quantity',
        'stock_before',
        'stock_after',
        'unit_cost',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
