<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'price',
        'cost',
        'quantity',
        'subtotal',
        'utility',
        'tax_id',
    ];



    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
     public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
