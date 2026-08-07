<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Customer extends Model
{
    use HasFactory;


    protected $fillable = [
        'full_name',
        'identification',
        'phone',
        'email',
        'address',
        'credit_amount',
        'departament_id',
        'city_id',
        'customer_tribute_id', // resposabilidad fiscal
        'identification_document_id', //tipo de documento cedula o nit
        'responsibilities', // responsable de iva
        'organization_type_id', // tipo de cliente persona natural o juridica
        'state',
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
    public function customerTribute(): BelongsTo
    {
        return $this->belongsTo(CustomerTributes::class);
    }
    public function identificationDocument(): BelongsTo
    {
        return $this->belongsTo(IdentityDocument::class);
    }
    public function organizationType(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }
}
