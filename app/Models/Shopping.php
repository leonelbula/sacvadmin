<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function shoppingDetail(): BelongsTo
    {
        return $this->belongsTo(ShoppingDetail::class);
    }
    public function details(): HasMany
    {
        return $this->hasMany(ShoppingDetail::class);
    }
}
