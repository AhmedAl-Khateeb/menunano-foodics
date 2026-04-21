<?php

namespace App\Models;

use App\Traits\SupplierTrait;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use SupplierTrait;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'contact_name',
        'phone',
        'email',
        'is_active',
    ];

    protected $casts = [
        'balance' => 'decimal:3',
        'opening_balance' => 'decimal:3',
        'current_balance' => 'decimal:3',
        'credit_limit' => 'decimal:3',
        'is_active' => 'boolean',
    ];

  
}
