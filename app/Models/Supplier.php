<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'identification_card',
        'address',
        'departament',
        'city',
        'phone',
        'email',
        'description',
        'credit_amount',
        'company_id',
    ];

    public function companydata(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function shopping(): HasMany
    {
        return $this->hasMany(Shopping::class);
    }
}
