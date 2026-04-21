<?php

namespace App\Models;

use App\Traits\PurchaseRequestTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use PurchaseRequestTrait;

    protected $fillable = [
        'user_id',
        'request_number',
        'request_date',
        'status',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'request_date' => 'date',
        'approved_at' => 'datetime',
    ];

}