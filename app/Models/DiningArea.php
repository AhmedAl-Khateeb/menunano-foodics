<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiningArea extends Model
{
    protected $fillable = ['name', 'user_id', 'is_active', 'branch_id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
