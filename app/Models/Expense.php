<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'total',
        'date',
        'delivered_to',
        'hour',
        'observation',
        'payment_method_id',
        'type_expense_id',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'total' => 'integer',
    ];

    /**
     * Método de pago utilizado para el gasto.
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(
            PaymentMethod::class,
            'payment_method_id'
        );
    }

    /**
     * Tipo de gasto.
     */
    public function typeExpense(): BelongsTo
    {
        return $this->belongsTo(
            TypeExpense::class,
            'type_expense_id'
        );
    }

    /**
     * Usuario que registró el gasto.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
