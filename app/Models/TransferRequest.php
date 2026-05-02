<?php

namespace App\Models;

use App\Traits\TransferRequestTrait;
use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    use TransferRequestTrait;

    protected $fillable = [
        'user_id',
        'transfer_number',
        'from_branch_id',
        'to_branch_id',
        'transfer_date',
        'status',
        'notes',
        'branch_id',
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

 
}