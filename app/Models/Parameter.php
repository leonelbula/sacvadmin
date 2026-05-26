<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToCompany;


class Parameter extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'sale_code',
        'tax_include',
        'product_code',
        'automatic_product',
        'company_id'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
