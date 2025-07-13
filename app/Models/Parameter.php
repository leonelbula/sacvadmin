<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_code',
        'prefix_sale',
        'product_code',
        'automatic_product',
        'company_id'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
