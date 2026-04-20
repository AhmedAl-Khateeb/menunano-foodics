<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'code',
        'description',
        'is_active',
        'cover',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class);
    }

    public function getCoverUrlAttribute()
    {
        if ($this->cover) {
            return asset('storage/'.$this->cover);
        }

        return null;
    }
}
