<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    protected $fillable = [
        'user_id',
        'transfer_number',
        'from_branch_id',
        'to_branch_id',
        'transfer_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransferRequestItem::class);
    }
}