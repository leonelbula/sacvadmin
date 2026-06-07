<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToCompany;

class Customer extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'full_name',
        'identification_card',
        'phone',
        'email',
        'address',
        'credit_amount',
        'departament_id',
        'city_id',
        'tax_id',
        'type_organice_id',
        'identity_document_id',
        'customer_tribute_id',
        'company_id'
    ];

    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
    public function separateplan(): HasMany
    {
        return $this->hasMany(SeparatePlan::class);
    }
    public function departament(): BelongsTo
    {
        return $this->belongsTo(Departament::class);
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
