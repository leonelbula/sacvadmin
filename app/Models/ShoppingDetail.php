<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingDetail extends Model
{
    protected $fillable = [
        'product_id', 'quantity', 'price','has_iva','subtotal','iva','total','company_id',
    ];

    public function shopping()
    {
        return $this->belongsTo(Shopping::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
