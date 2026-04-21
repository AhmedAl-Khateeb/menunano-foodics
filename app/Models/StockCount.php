<?php

namespace App\Models;

use App\Traits\StockCountTrait;
use Illuminate\Database\Eloquent\Model;

class StockCount extends Model
{
    use StockCountTrait;

    protected $fillable = [
        'user_id',
        'count_number',
        'count_date',
        'type',
        'status',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'count_date' => 'date',
        'approved_at' => 'datetime',
    ];


}
