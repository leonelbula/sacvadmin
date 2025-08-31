<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReturnSale extends Model
{
    use HasFactory;


     protected $fillable = [
        'returnsale_number',
        'cost',
        'utility',
        'subtotal',
        'total_iva',
        'total',
        'hour',
        'date_sale',
        'reason',
        'customer_id',
        'company_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function returnSaleDetail(): BelongsTo
    {
        return $this->belongsTo(ReturnSaleDetail::class);
    }
    public function details(): HasMany
    {
        return $this->hasMany(ReturnSaleDetail::class);
    }
}
