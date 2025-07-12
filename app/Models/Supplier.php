<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'identification_card',
        'address',
        'department',
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
}
