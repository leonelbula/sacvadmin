<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class SaleReturn extends Model
{
    protected $fillable = [
        'return_number',
        'sale_id',
        'customer_id',
        'user_id',
        'cost',
        'total',
        'reason',
        'refund_type',
        'state',
        'observation',
    ];

    /*
    |--------------------------------------------------------------------------
    | Venta original
    |--------------------------------------------------------------------------
    */

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Cliente
    |--------------------------------------------------------------------------
    */

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Usuario que realizó la devolución
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Detalles de la devolución
    |--------------------------------------------------------------------------
    */

    public function details(): HasMany
    {
        return $this->hasMany(SaleReturnsDetails::class);
    }
}
