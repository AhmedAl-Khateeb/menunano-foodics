<?php

namespace App\Models;

use App\Traits\RecipeTrait;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use RecipeTrait;

    protected $fillable = [
        'user_id',
        'output_raw_material_id',
        'name',
        'yield_quantity',
        'yield_unit_id',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'yield_quantity' => 'decimal:3',
        'is_active' => 'boolean',
    ];

}
