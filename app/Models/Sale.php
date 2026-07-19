<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToCompany;

class Sale extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'sale_number',
        'cost',
        'utility',
        'subtotal',
        'total_iva',
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
        'company_id',
        'user_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
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
