<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departament extends Model
{
    public function customer(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
