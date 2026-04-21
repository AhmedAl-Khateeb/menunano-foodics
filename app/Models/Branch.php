<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory,BranchTrait;

    protected $fillable = [
        'name',
        'code',
        'phone',
        'address',
        'is_active',
        'created_by',
        // 'user_id',
    ];

 
}
