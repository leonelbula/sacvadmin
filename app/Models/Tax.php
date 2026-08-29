<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tax extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'value',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
