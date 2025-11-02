<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    protected $fillable = [
        'sale_id',
        'amount',
        'date',
        'note',
        'user_id',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
