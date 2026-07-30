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
        'department',
        'city',
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
    
}
