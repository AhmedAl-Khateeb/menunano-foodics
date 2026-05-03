<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    // use HasFactory;

    protected $table = 'salary';

    protected $fillable = ['staff_id', 'Days', 'Main Hours', 'per Days', 'Active Hour', 'In Day', 'user_id', 'created_at', 'updated_at', 'created_by'];

    public $timestamps=true;   // default  true or false

}
