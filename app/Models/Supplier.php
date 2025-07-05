<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
          'full_name',
            'identification_card',
            'address' ,
            'department',
            'city',
            'phone',
            'email',
            'description',
            'credit_amount',
    ];
}
