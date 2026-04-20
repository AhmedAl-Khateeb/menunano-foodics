<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCount extends Model
{
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(StockCountItem::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
