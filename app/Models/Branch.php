<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    use BranchTrait;

    protected $fillable = [
        'name',
        'code',
        'phone',
        'address',
        'is_active',
        'created_by',
        'business_id',
        'owner_id',
    ];
}
