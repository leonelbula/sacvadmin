<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcountPayablePayment extends Model
{
    protected $fillable = [
        'shopping_id',
        'user_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference',
        'observation',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:0',
            'payment_date' => 'date',
        ];
    }

    public function shopping(): BelongsTo
    {
        return $this->belongsTo(Shopping::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
