<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shopping extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'shopping_date',
        'purchase_type',
        'subtotal',
        'iva',
        'total',
        'balance',
        'expiration_date',
        'supplier_id',
        'company_id',
        'user_id'
    ];


    public function details()
    {
        return $this->hasMany(ShoppingDetail::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
