<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pos extends Model
{
    protected $fillable = [
        'box_base',
        'total_sale',
        'difference',
        'start_time',
        'closing_time',
        'start_date',
        'closing_date',
        'bills',
        'consignment',
        'cash',
        'returns_sale',
        'delivered_value',
        'state',
        'user_id',
        'company_id'
    ];
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
