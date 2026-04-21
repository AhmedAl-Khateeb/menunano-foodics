<?php

namespace App\Models;

use App\Traits\TableTrait;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use TableTrait;

    protected $fillable = ['name', 'dining_area_id', 'capacity', 'is_active', 'user_id'];

 
}
