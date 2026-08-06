<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_number',
        'cost',
        'utility',
        'subtotal',
        'total',
        'balance',
        'hour',
        'date_sale',
        'term',
        'expiration_date',
        'type_sale',
        'payment_form',
        'payment_method',
        'customer_id',
        'user_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function saleDetail(): BelongsTo
    {
        return $this->belongsTo(SaleDetail::class);
    }
    public function details(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }
    public function payments()
    {
        return $this->hasMany(SalePayment::class);
    }
}
