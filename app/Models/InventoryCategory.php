<?php

namespace App\Models;

use App\Traits\InventoryCategoryTrait;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    use InventoryCategoryTrait;

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


    public function getCoverUrlAttribute()
    {
        if ($this->cover) {
            return asset('storage/'.$this->cover);
        }

        return null;
    }
}
