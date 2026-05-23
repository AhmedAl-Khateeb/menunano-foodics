<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'Name',
        'Number_of_hours',
        'Number_of_days',
        'mobile',
        'Start_date',
        'End_date',
        'attach_File',
        'Salary',
        'user_id',
        'created_at',
        'updated_at',
        'created_by',
    ];

    public $timestamps = true;
}
