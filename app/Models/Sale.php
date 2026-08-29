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
        'payment_form',
        'payment_method_id',
        'observation',
        'taxes',
        'customer_id',
        'user_id',
        'state',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // CORREGIDO: Se eliminó el método saleDetail() de aquí

    public function details(): HasMany
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
