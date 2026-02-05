<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'type',
        'allow_decimal',
        'is_active',
        'base_unit_id',
        'conversion_rate',
        'user_id',
    ];

    protected $casts = [
        'allow_decimal' => 'boolean',
        'is_active' => 'boolean',
        'conversion_rate' => 'decimal:4',
    ];

    protected static function booted()
    {
        static::addGlobalScope('user_id', function ($builder) {
            if (auth()->check()) {
                 $builder->where('user_id', auth()->id());
            }
        });

        static::creating(function ($unit) {
            if (auth()->check()) {
                $unit->user_id = auth()->id();
            }
        });
    }

    public function baseUnit()
    {
        return $this->belongsTo(Unit::class, 'base_unit_id');
    }

    public function subUnits()
    {
        return $this->hasMany(Unit::class, 'base_unit_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBase($query)
    {
        return $query->whereNull('base_unit_id');
    }
}
