<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charge extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'charges';

    protected $fillable = [
        'name',
        'classification',
        'type',
        'value',
        'is_inclusive',
        'description',
        'is_active',
        'applicable_order_types',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_inclusive' => 'boolean',
        'value' => 'decimal:2',
        'applicable_order_types' => 'array',
    ];

    protected static function booted()
    {
        static::addGlobalScope('user_id', function ($builder) {
            if (auth()->check()) {
                 $builder->where('user_id', auth()->id());
            }
        });

        static::creating(function ($tax) {
            if (auth()->check()) {
                $tax->user_id = auth()->id();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
