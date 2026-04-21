<?php

namespace App\Models;

use App\Traits\PackageTrait;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use PackageTrait;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'business_type_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
