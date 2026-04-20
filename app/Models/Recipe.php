<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipeable()
    {
        return $this->morphTo();
    }

    public function yieldUnit()
    {
        return $this->belongsTo(Unit::class, 'yield_unit_id');
    }

    public function outputMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'output_raw_material_id');
    }


    public function items()
    {
        return $this->hasMany(RecipeItem::class);
    }

    public function productionOrders()
    {
        return $this->hasMany(ProductionOrder::class);
    }
}
