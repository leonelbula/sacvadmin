<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class typeExpense extends Model
{

    protected $fillable = [
        'description'
    ];

    public function Expense(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
