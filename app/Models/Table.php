<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['name', 'dining_area_id', 'capacity', 'is_active', 'user_id'];

    public function diningArea()
    {
        return $this->belongsTo(DiningArea::class);
    }
}
