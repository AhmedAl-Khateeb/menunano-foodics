<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function calculate(string $subtotal)
    {
        if (!$this->is_active) {
            return 0;
        }

        if ($this->type === 'percentage') {
            return $subtotal * ($this->value / 100);
        }

        return $this->value;
    }
}
