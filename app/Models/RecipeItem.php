<?php

namespace App\Models;

use App\Traits\RecipeItemTrait;
use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model
{
    use RecipeItemTrait;

    protected $fillable = [
        'recipe_id',
        'raw_material_id',
        'unit_id',
        'quantity',
        'waste_percent',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'waste_percent' => 'decimal:2',
    ];

}