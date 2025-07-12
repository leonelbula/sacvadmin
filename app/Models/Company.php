<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'identification_card',
        'phone',
        'email',
        'address',
        'department',
        'city',
        'logo',
        'user_id',
    ];
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }
    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class);
    }
}
