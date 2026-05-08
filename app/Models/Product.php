<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Scopes\CompanyScope;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'cost',
        'price',
        'utility',
        'minimum_amount',
        'amount',
        'tax',
        'tax_value',
        'state',
        'product_type_id',
        'taxes_id',
        'category_id',
        'company_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function kardex()
    {
        return $this->hasMany(Kardex::class);
    }
}
