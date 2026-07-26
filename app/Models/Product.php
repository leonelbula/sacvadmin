<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'cost',
        'price',
        'utility',
        'stock_min',
        'stock',
        'state',
        'category_id',
    ];

   

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function kardex()
    {
        return $this->hasMany(Kardex::class);
    }
}
